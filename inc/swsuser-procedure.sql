delimiter $$
drop procedure if exists addRebate$$
create procedure addRebate( in valueList varchar(1024) )
TAG:BEGIN
	#("'43','0.98','2009-05-01','2020-12-31','1'") 
	declare continue handler for SQLEXCEPTION
	BEGIN
		set @status=1;
	END;
	set @status=0;

	select substring_index( valueList, ',', 1 ) into @accessKey;
	select substring_index( valueList, ',', -1 ) into @systemUserID;
	select substring_index( substring_index( valueList, ',', 3 ), ',', -1 ) into @beginTime;
	set @beginTime = replace( @beginTime, '\'', '' );
	set @accessKey = replace( @accessKey, '\'', '' );
	set @systemUserID = replace( @systemUserID, '\'', '' );
	if ( ( @userID = '0' ) or ( length( @accessKey ) = 0 ) ) then
		select 0 as retNum, '用户id数据无效!' as errMsg;
		leave TAG;
	end if;
	set @tmpValue = '';
	select id into @tmpValue from rebate where accessKey=@accessKey and beginTime > now() limit 1;
	if ( length( @tmpValue ) <> 0 ) then
		select 0 as retNum, '此用户下个月的折扣已经填加，请确认!' as errMsg;
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
	
	set @rebateID = '';
	select id into @rebateID from rebate where accessKey=@accessKey and beginTime=@beginTime limit 1;
	if ( length( @rebateID ) <> 0) then
		select 0 as retNum, '此月折扣已经存在！' as errMsg;
		leave TAG;
	end if;
	set @rebateID = '';
	start transaction;
	select max(id) into @rebateID from rebate where accessKey=@accessKey limit 1;
	if ( length( @rebateID ) = 0  or isNull( @rebateID ) ) then #若之前没有数据的话
		set @sqlStr = concat( 'insert into rebate( accessKey, value, beginTime ) values(\'', @accessKey, '\',1', ',\'', @currentMonth, '\')' );
		prepare stmt from @sqlStr;
		execute stmt;
		if ( @status = 1 ) then
			select 0 as retNum, concat( 'init rebate failed(1)', @sqlStr ) as errMsg;
			leave TAG;
		end if;

	end if;
	select max(id) into @rebateID from rebate where accessKey=@accessKey limit 1;
	if ( length( @rebateID ) = 0 or isNull( @rebateID )  ) then #若之前没有数据的话
		rollback;
		select 0 as retNum, 'init rebate failed(2)' as errMsg;
		leave TAG;
	end if;
	update rebate set endTime=date_add( @currentMonth, interval -1 day ) where id=@rebateID limit 1;
	if ( @status = 1 ) then
		rollback;
		select 0 as retNum, 'init rebate failed(3)' as errMsg;
		leave TAG;
	end if;
	set @sqlStr = concat( 'insert into rebate ( accessKey, value, beginTime, systemUserID ) values(', valueList, ')' );
	prepare stmt from @sqlStr;
	execute stmt;
	if ( @status = 1 ) then
		select 0 as retNum, concat( 'insert rebate failed(3)', @sqlStr ) as errMsg;
		rollback;
		leave TAG;
	end if;
	commit;
	select 1 as retNum, 'success!' as errMsg;
END$$
delimiter ;