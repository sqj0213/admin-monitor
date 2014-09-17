delimiter $$
drop procedure if exists addPrice$$
create procedure addPrice( in valueList varchar(1024) )
TAG:BEGIN
	#("'6','10','0.08','秒','2009-05-01','1'") 
	#select 0 as retNum, valueList as errMsg;
	#leave TAG;
	declare continue handler for SQLEXCEPTION
	BEGIN
		set @status=1;
	END;
	set @status=0;

	select substring_index( valueList, ',', -1 ) into @systemUserID;
	select substring_index( substring_index( valueList, ',', 5 ), ',', -1 ) into @beginTime;
	select substring_index( valueList, ',', 1 ) into @productID;
	select substring_index( substring_index( valueList, ',', 2 ), ',', -1 ) into @priceItemID;

	select substring_index( substring_index( valueList, ',', 4 ), ',', -1 ) into @unit;


	set @beginTime = replace( @beginTime, '\'', '' );
	set @systemUserID = replace( @systemUserID, '\'', '' );
	set @productID = replace( @productID, '\'', '' );
	set @priceItemID = replace( @priceItemID, '\'', '' );
	set @unit = replace( @unit, '\'', '' );

	set @tmpValue = '';
	select id into @tmpValue from swsPrice where swsID=@productID and priceItemID=@priceItemID and beginTime > now() limit 1;
	if ( length( @tmpValue ) <> 0 ) then
		select 0 as retNum, '此产品类型的计费项下个月的价格已经填加，请确认!' as errMsg;
		leave TAG;
	end if;
	set @currentMonth = '';
	select date_format( curdate(), "%Y-%m-01") into @currentMonth;
	set @nextMonth = '';
	select date_add( @currentMonth, interval 1 month ) into @nextMonth;
	if ( unix_timestamp( @beginTime ) <> unix_timestamp( @nextMonth ) ) then
		select 0 as retNum, '折扣开始时间错误,只能为整月，且只能为当前月份的下一个月，格式如:2009-04-01' as errMsg;
		leave TAG;
	end if;
	
	set @swsPriceID = '';
	select id into @swsPriceID from swsPrice where swsID=@productID and priceItemID=@priceItemID and beginTime=@beginTime limit 1;
	if ( length( @swsPriceID ) <> 0 ) then
		select 0 as retNum, '此月折扣已经存在！' as errMsg;
		leave TAG;
	end if;
	set @swsPriceID = '';
	start transaction;
	select max(id) into @swsPriceID from swsPrice where swsID=@productID and priceItemID=@priceItemID limit 1;
	if ( length( @swsPriceID ) = 0 ) then #若之前没有数据的话
		#("'6','10','0.08','秒','2009-05-01','1'") 
		set @sqlStr = concat( 'insert into swsPrice( swsID, priceItemID, value, unit, beginTime, systemUserID ) values(', @productID, @priceItemID, '1', '\'', @unit, '\'', '\'', @currentMonth, '\'', @systemUserID,' )' );
		prepare stmt from @sqlStr;
		execute stmt;
		if ( @status = 1 ) then
			select 0 as retNum, 'init swsPrice failed(1)' as errMsg;
			leave TAG;
		end if;
		leave TAG;
	end if;
	set @swsPriceID = '';
	select max(id) into @swsPriceID from swsPrice where swsID=@productID and priceItemID=@priceItemID limit 1;
	if ( length( @rebateID ) = 0 ) then
		rollback;
		select 0 as retNum, 'init swsPrice failed(2)' as errMsg;
		leave TAG;
	end if;
	update swsPrice set endTime=date_add( @beginTime, interval -1 day ) where id=@swsPriceID limit 1;
	if ( @status = 1 ) then
		rollback;
		select 0 as retNum, 'init swsPrice failed(3)' as errMsg;
		leave TAG;
	end if;
	set @sqlStr = concat( 'insert into swsPrice( swsID, priceItemID, value, unit, beginTime, systemUserID ) values(', valueList,' )' );
	prepare stmt from @sqlStr;
	execute stmt;
	if ( @status = 1 ) then
		select 0 as retNum, 'insert swsPrice failed(4)' as errMsg;
		rollback;
		leave TAG;
	end if;
	commit;
	select 1 as retNum, 'success!' as errMsg;
END$$
delimiter ;