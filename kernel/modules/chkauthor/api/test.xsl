<?xml version="1.0" encoding="utf-8"?>

<xsl:transform version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" indent="yes"/> 
<xsl:output doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/> 
<xsl:output doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/> 


<xsl:template match="/">
<html xmlns="http://www.w3.org/1999/xhtml" lang="utf-8"> 
<head> 
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
  <style>body {background:#785c36} </style> 
  </head> 
  <body>
    <h2>My CD Collection</h2>
    <table border="1">
    <tr bgcolor="#9acd32">
      <th align="left">menuID</th>
      <th align="left">menuData</th>
      <th align="left">menuLink</th>
      <th align="left">menuName</th>
    </tr>
    <xsl:for-each select="dataStore/*">
    <tr>
      <td><xsl:value-of select="MenuId"/></td>
      <td><xsl:value-of select="MenuName"/></td>
      <td><xsl:value-of select="MenuLink"/></td>
      <td><xsl:value-of select="MenuName"/></td>
    </tr>
    </xsl:for-each>
    </table>
  </body>
  </html>
</xsl:template>

</xsl:transform >