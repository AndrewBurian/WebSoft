<!--
    Document   : locations.xsl
    Created on : April 4, 2014, 1:56 PM
    Author     : Andrew & Chris
    Description:
        Transforms the raw XML data into a table, listing each city,
        the bars in that city, and then a sum total per city
-->

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <!-- Template that will transform the entire document -->
    <xsl:template match="/">
        <table>
            <!-- Print the table headers -->
            <tr>
                <td>Establishment</td>
                <td>Address</td>
                <td>Capacity</td>
            </tr>
            <!-- Get all the CITY elements under the ESTABLISHMENTS root -->
            <xsl:for-each select="ESTABLISHMENTS/CITY">
                <tr>
                    <th>
                        <b>
                            <!-- Get the name attribute of the selected CITY -->
                            <xsl:value-of select="@name" />
                        </b>
                    </th>
                </tr>
                <!-- Get every BAR element under the selected CITY -->
                <xsl:for-each select="BAR">
                    <tr>
                        <!-- The bar's name -->
                        <td>
                            <xsl:value-of select="NAME" />
                        </td>
                        <!-- The bar's address -->
                        <td>
                            <xsl:value-of select="ADDRESS" />
                        </td>
                        <!-- The bar's capacity  -->
                        <td>
                            <xsl:value-of select="CAPACITY" />
                        </td>
                    </tr>
                </xsl:for-each>
                <!-- The sum total of the number of bars in this city -->
                <tr>
                    <xsl:value-of select="@name" /> has <xsl:value-of select="count(BAR)" /> bars.
                </tr>
            </xsl:for-each>
        </table>
    </xsl:template>

</xsl:stylesheet>
