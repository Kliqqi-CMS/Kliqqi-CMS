<?php

/**
 * This class is a set of static utilities functions made to easier 
 * programming for all applications that use PHP.

 */
class phputils
{

    /**
     * Encode a string to utf-16 charset
     * 
     * @param string $str
     * @return string
     */
    public static function utf16_encode($str)
    {
        return mb_convert_encoding($str, "utf-16");
    }

    /**
     * Dencode a string to utf-16 charset
     * 
     * @param string $str
     * @return string
     */
    public static function utf16_decode($str)
    {
        return mb_convert_encoding($str, "utf-8", "utf-16");
    }

    /**
     * Build an sql portion to search a sentence inside 
     * one or more fields
     * 
     * Example:
     * searching Apple Ipod into fields name and description will produce:
     * (name LIKE '%Apple%' and name LIKE %ipod) OR (description LIKE '%Apple%' and description LIKE %ipod)
     * 
     * @param mixed $fields         can be an array or a string
     * @param string $sentence 
     * 
     * @return string
     */
    public static function getSqlSearchSentence($fields, $sentence)
    {
        // Create the string for each fields
        // ie (name LIKE '%Apple%' and name LIKE %ipod) OR (description LIKE '%Apple%' and description LIKE %ipod)
        $final_seq = "";

        //Shift words
        $parole = explode(" ", $sentence);

        //Setting a single array if it was pass a single string insthead an array
        if (is_string($fields)) {
            $fields = array($fields);
        }

        $sub_queries = array();
        foreach ($fields as $field):

            $sub_seq = array();
            foreach ($parole as $parola):
                $sub_seq[] = "$field LIKE '%" . addslashes($parola) . "%'";
            endforeach;

            $sub_queries[] = "(" . implode(" AND ", $sub_seq) . ")";

        endforeach;

        if (count($sub_queries) > 1) {
            $final_seq = " ( " . implode(" OR ", $sub_queries) . " ) ";
        } else {
            $final_seq = $sub_queries[0];
        }

        return $final_seq;
    }

    
    
    /**
     * Create a txt string from an html document
     * 
     * @param string $document
     * @return string
     */
    public static function html2txt($document)
    {
        $document = preg_replace("'<style[^>]*>.*</style>'siU", '', $document);
        $search = array('@<script[^>]*?>.*?</script>@si', // Strip out javascript
            '@<[\/\!]*?[^<>]*?>@si', // Strip out HTML tags
            '@<style[^>]*?>.*?</style>@siU', // Strip style tags properly
            '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
        );
        $text = preg_replace($search, '', $document);
        return $text;
    }

    /**
     * return the array cleaned by his values putting
     * $empty_value parameter
     * without touching keys
     *
     * @param array $array
     * @param string $empty_value
     * @return array
     */
    public static function array_clear_values(&$array, $empty_value = "")
    {
        //reset the pointer
        reset($array);
        foreach ($array as $key => $value):
            $array[$key] = $empty_value;
        endforeach;

        //reset the pointer again
        reset($array);
        return $array;
    }

    
    
    /**
     * Create a string for a fulltext search.
     * Assuming that fields was correctly indexed into mysql
     * 
     * @param string $string
     * @return string
     */
    public static function getFullTextSearchString($string)
    {
        //Search for char ", that assume a sentence search
        //with multiple values set by user
        if (strpos($string, "\",") !== false) {
            $els = explode("\",", $string);
            //Last double quote reached
            $els_search = array();
            foreach ($els as $el):
                if (empty($el))
                    continue;
                $els_search[] = $el . "\"";
            endforeach;
        }
        else {
            //Building manual search
            $search_string = str_replace("\", ", "\" ", $string);

            //Take off last comma if it's presents
            $revstr = strrev($search_string);
            $last_letter = $revstr{0};
            if ($last_letter == ",") {
                $search_string = substr($search_string, 0, strlen($search_string) - 1);
            }

            //Get values mantaining sentences under doubles quotes
            preg_match_all('/"(?:\\\\.|[^\\\\"])*"|\S+/', $search_string, $els_search);
            if (empty($els_search[0])) {
                $els_search = str_getcsv($search_string, " ");
            } else {
                $els_search = $els_search[0];
            }


            //Exact sentence if founds more than 2 elements
            if (count($els_search) > 2) {
                $els_search[-1] = '"' . addslashes($string) . '"';
                ksort($els_search);
            }
        }


        //Insert terms under double quotes
        $sqlEls = array();
        if (empty($els_search)) {
            return "";
        }


        foreach ($els_search as $el)
        {
            $first_letter = $el{0};
            $revstr = strrev($el);
            $last_letter = $revstr{0};
            if ($first_letter == "\"" && $last_letter == "\"") {
                //Entire sentence
                $sqlEls[] = addslashes($el);
            } else {
                //Include element
                if (strlen($el) > 3) {
                    //Minimun chars for fulltext search
                    $sqlEls[] = addslashes($el);
                }
            }
        }

        $fulltext_string = "'" . implode_not_empty(" ", $sqlEls, false, false, true, true) . "'";
        return $fulltext_string;
    }

    
    /**
     * Execute the whois for a specified address.
     * It work with systems with the whois functions inside
     *
     * @param string $remote_ip
     * @return string
     */
    public static function whois($remote_ip)
    {
        //Whois ip
        $whois_text = "";
        if (!empty($remote_ip)) {

            @exec("whois $remote_ip", $output, $return_var);
            if ($return_var == 0) {
                foreach ($output as $line)
                {
                    $whois_text .= "\n$line";
                }
            } else {
                throw new Exception("whois command is not present in your system");
            }
        }
        return $whois_text;
    }

    /**
     * Test if one or more tables 
     * are current used by the database.
     *
     * @param mysql pointer $link_id
     * @param string $db_name
     * @param array $array_tables_names
     * @return boolean
     */
    public static function tablesLocked($link_identifier, $db_name, $array_tables_names)
    {
        $sql = "SHOW OPEN TABLES FROM `" . $db_name . "`
                WHERE In_use > 0
                AND
                `Table` IN (";

        $tables = count($array_tables_names);
        for ($i = 0; $i < $tables; $i++):
            $sql .= "'" . $array_tables_names[$i] . "'";
            if ($i < ($tables - 1))
                $sql .= ",";
        endfor;

        $sql .= ")";
        $rs = mysql_query($sql, $link_identifier);
        return mysql_num_rows($rs) > 0;
    }

    
    /**
     * Create a form and submit it to open the order inside the ebay site.
     * To do it you must be logged in into ebay first
     * 
     * @param int $ebaySalesRecordNumber
     * @param string $actionUrl
     * @return string
     */
    public static function getEbaySearchSaleRecordNumberForm($ebaySalesRecordNumber, $actionUrl = "http://k2b-bulk.ebay.it/ws/eBayISAPI.dll")
    {
        $html = '<form style="display: none" id="mu_form_id" name="mu_form_id" method="get"
                    action="' . $actionUrl . '">
                    <input id="MfcISAPICommand" type="hidden" name="MfcISAPICommand" value="SalesRecordConsole">
                    <input id="currentpage" type="hidden" name="currentpage" value="SCSold">
                    <input id="pageNumber" type="hidden" name="pageNumber" value="1">
                    <input id="urlStack" type="hidden" name="urlStack" value="5508|Period_Last31Days|currentpage_SCSold|">

                    <input id="searchField" type="hidden" name="searchField" value="SalesRecordNumber">
                    <input id="StoreCategory" type="hidden" name="StoreCategory" value="-4">
                    <input id="Status" type="hidden" name="Status" value="All">
                    <input id="Period" type="hidden" name="Period" value="Last365Days">


                    <input type="hidden" value="' . form_prep($ebaySalesRecordNumber) . '" maxlength="129" name="searchValues" id="searchValues">

                    <input type="submit" name="searchSubmit" value="Cerca" id="searchbutton" style="margin:0 6px 0 6px">

                </form>
                <script type="text/javascript">document.getElementById("mu_form_id").submit()</script>
                ';

        return $html;
    }

    
    /**
     * Convert a name from the italian short month name to english short month name
     * 
     * @param string $italianDate a date with italian format (dd/mm/yyyy)
     * @return string
     */
    public static function getShortEnglishMonth($italianDate)
    {
        $it_values = array("gen", "feb", "mar", "apr", "mag", "giu", "lug", "ago", "set", "sett", "ott", "nov", "dic");
        $en_values = array("jan", "feb", "mar", "apr", "may", "jun", "jul", "aug", "sep", "sep", "oct", "nov", "dec");
        $italianDate = strtolower($italianDate);
        $text = str_replace($it_values, $en_values, $italianDate);
        return $text;
    }

    /**
     * Used on combination with php's usort function
     * to compare classes into an array with own 
     * defined method
     * __toString()
     * 
     * @param class $obj_a
     * @param class $obj_b
     * @return mixed
     */
    public static function sortObject($obj_a, $obj_b)
    {
        return strcmp($obj_a->__toString(), $obj_b->__toString());
    }

    /**
     * Retreive the IE version from the current user agent
     */
    public static function ieversion()
    {
        preg_match('|MSIE ([0-9]\.[0-9])|', @$_SERVER['HTTP_USER_AGENT'], $reg);
        if (!isset($reg[1])) {
            return -1;
        } else {
            return floatval($reg[1]);
        }
    }

    /**
     * If this function doesn't exists into php globals functions
     * Convert all new line from a string with a standard br tag
     * 
     * @param string $text
     * @return string
     */
    public static function ln2br($text)
    {
        return strtr($text, array("\r\n" => '<br />', "\r" => '<br />', "\n" => '<br />'));
    }

    
    
    /**
     * Return a list of all databases with the possibility to 
     * search and filter them
     * 
     * % as jolly char
     *
     * @param mysql pointer $link_identifier
     * @param string $search_string
     */
    public static function getDatabasesByName($link_identifier, $search_string)
    {
        $sql = "SHOW DATABASES WHERE `Database` LIKE '%" . addslashes($search_string) . "%' ";
        $rs = mysql_query($sql, $link_identifier);
        $res = array();
        while ($row = mysql_fetch_object($rs))
        {
            $res[] = $row->Database;
        }

        @mysql_free_result($rs);
        return $res;
    }

    /**
     * Set the correct headers to retreive a json output
     * 
     * @param string $string simple string
     * @return string json string format
     */
    public static function json_real_encode($string)
    {
        @header('Cache-Control: no-cache, must-revalidate');
        @header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        @header('Content-type: application/json');

        return json_encode($string);
    }

    /**
     * Return an utf8 array charset values with inside all elements
     * converted to json
     * 
     * @param $input_array
     * @return array
     */
    public static function utf8json($input_array)
    {

        static $depth = 0;

        /* our return object */
        $newArray = array();

        /* safety recursion limit */
        $depth++;
        if ($depth >= '30') {
            return false;
        }

        /* step through inArray */
        foreach ($input_array as $key => $val)
        {
            if (is_array($val)) {
                /* recurse on array elements */
                $newArray[$key] = utf8json($val);
            } else {
                /* encode string values */
                $newArray[$key] = utf8_encode($val);
            }
        }

        /* return utf8 encoded array */
        return $newArray;
    }

    /**
     * Return the first value from the first row of a mysql resultset.
     * Generally used to parse a query like :
     *      SELECT COUNT(*) AS total_rows FROM MY_TABLE...
     * 
     * @param mixed $resultset
     * @param string $total_field_name  Default "total_rows"
     * 
     * @return int
     */
    public static function getResultCounter($resultset, $total_field_name = "total_rows")
    {
        if (empty($resultset)) return 0;
        
        if($resultset instanceof CI_DB_mysql_result) {
            //CodeIgniter resultset
            if ($resultset->num_rows() <= 0) return 0;
            $row = $resultset->row();
        }
        else if($resultset instanceof mysqli_result) {
            //mysqli object resultset
            if($resultset->num_rows <= 0) return 0;
            $row = $resultset->fetch_object();
        }
        else {
            //Standard mysql resultset
            if (mysql_num_rows($resultset) <= 0) return 0;
            $row = mysql_fetch_object($resultset);
        }        
        
        return $row->$total_field_name;
    }

    
    /**
     * Return the X value by the following operation
     *
     * $a : $b = $c : X
     *
     * @param float $a
     * @param float $b
     * @param float $c
     * 
     * @return float
     */
    public static function getProportionValue($a, $b, $c)
    {
        return (float) ((float) ($b * $c) / $a);
    }
    

    /**
     * Create the implode but taking off
     * all empty values from the given array
     *
     * @param string $glue, 
     * @param array $array
     * @param boolean $quote_els        if true surrond elements with single quotes
     * @param boolean addslashes_els    if true apply the addslashes function to each element
     * @param boolean $trim_els         if true apply the trim function to each element
     * @param boolean $remove_double_spaces     if true apply the self::remove_double_spaces function by this utility
     */
    public static function implode_not_empty($glue, $array, $quote_els = false, $addslashes_els = false, $trim_els = false, $remove_double_spaces = false)
    {
        $res = "";
        foreach ($array as $el)
        {
            if (!empty($el)) {
                if ($trim_els) {
                    $el = trim($el);
                }
                if ($remove_double_spaces) {
                    $el = self::remove_double_spaces($el);
                }
                if ($addslashes_els) {
                    $el = addslashes($el);
                }
                if ($quote_els) {
                    $el = "'" . $el . "'";
                }
                $res .= (empty($res)) ? $el : $glue . $el;
            }
        }
        return $res;
    }

    
    
    /**
     * Convert a bytes dimension to a human readable format
     * Return an array with the following format:
     *  
     *      $dimensions["bytes"]
     *      $dimensions["kilobytes"]
     *      $dimensions["megabytes"]
     *      $dimensions["gigabytes"]
     * 
     * @see self::confert
     * 
     * @param int $bytes
     * @return array
     */
    public static function get_human_dimensions($bytes)
    {
        $dimensions["bytes"] = $bytes;
        $dimensions["kilobytes"] = number_format(($bytes / 1024 * 100000) / 100000, 2, ".", "");
        $dimensions["megabytes"] = number_format(($bytes / 1048576 * 100000) / 100000, 2, ".", "");
        $dimensions["gigabytes"] = number_format(($bytes / 1073741824 * 100000) / 100000, 2, ".", "");
        return $dimensions;
    }

    
    /**
     * converte una dimensione in bytes, kb etc
     * Convert a bytes dimension a more readable dimension
     * 
     * @see self::get_human_dimensions
     * 
     * @param float $size
     * @return float;
     */
    public static function convert($size)
    {
        $unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }
    
    
    
    
    /**
     * Return a portion from a given string taking it from a starting element
     * to an ending element instead of the classical normal number position
     * 
     * @param string $string
     * @param string $start_element
     * @param string $end_element
     * @return string
     */
    public static function str_get_portion($string, $start_element, $end_element)
    {
        preg_match('/' . $start_element . '(.?)*' . $end_element . '/m', $string, $matches);
        if (empty($matches) || empty($matches[0]))
            return "";
        else
            return (string) str_replace($end_element, "", str_replace($start_element, "", $matches[0]));
    }

    
    /**
     * Search and replace a portion of code starting
     * from the given tag end ending to the end_tag parameter
     * 
     * @param string $start_tag
     * @param string $end_tag
     * @param string $replace
     * @param string $string
     * @return string
     */
    public static function str_replace_code($start_tag, $end_tag, $replace, $string)
    {
        $code_start = strpos($string, $start_tag);
        $code_end = strpos($string, $end_tag);

        if ($code_start === false || $code_end === false) {
            return $string;
        }

        $substr_start = substr($string, 0, $code_start);
        $substr_end = substr($string, $code_end + strlen($end_tag));

        return $substr_start . $replace . $substr_end;
    }

    
    /**
     * Return the sha512 value
     * 
     * @param string $value
     * @return string
     */
    public static function sha512($value)
    {
        return hash("sha512", $value);
    }

    
    /**
     * Open a pointer to the internal log to print custom messages
     * using the method printInternalLog
     * 
     * @see self::printInternalLog
     */
    public static function openInternalLog()
    {
        openlog(__CLASS__, LOG_PID | LOG_PERROR, LOG_LOCAL0);
    }

    /**
     * Generate a system log message
     * 
     * @see self::openInternalLog
     * 
     * @param string $value
     * @param int $logType
     */
    public static function printInternalLog($value, $logType = LOG_WARNING)
    {
        syslog($logType, date("Y-m-d H:i:s") . ": " . $value);
    }

    
    /**
     * Close connection to system logger
     */
    public static function closeInternalLog()
    {
        @closelog();
    }

    
    
    /**
     * Force the browser to start a buffer on screen and parse
     * all future messages when it will founds $endofsection sentence
     * 
     * It can be deactivated by script setting the global $_POST["no_buffers"]
     * variable to a not empty value
     */
    public static function start_buffer($endofsection = "endofsection")
    {
        if (!empty($_POST['no_buffers'])) return;
        header('Content-type: multipart/x-mixed-replace;boundary='.$endofsection);
    }

    
    /**
     * Force the browser to read a buffer on screen and parse it.
     * To use this method it's necessary to use start_buffer first.
     * 
     * With this method you can update the browser output without ajax
     * or any other technologies but simply using it in your php script
     * on server side. (For example into a simple cicle)
     * 
     * It can be deactivated by script setting the global $_POST["no_buffers"]
     * variable to a not empty value
     */
    public static function print_buffer($value, $content_type = "text/plain", $endofsection = "endofsection")
    {
        if (!empty($_POST['no_buffers']))
            return;

        print "Content-type: $content_type\n\n";
        print $value;
        print "\n";
        print "--".$endofsection;
        print "\n";
        @ob_flush();
        flush();
    }

    
    
    /**
     * Limit chars from the given string
     * with the possibility to set a minimum words to be included
     * into returned string
     * 
     * @param string $str
     * @param string $length
     * @param int $minword
     * @return type
     */
    public static function limit_char($str, $length, $minword = 3)
    {
        $sub = '';
        $len = 0;

        foreach (explode(' ', $str) as $word)
        {
            $part = (($sub != '') ? ' ' : '') . $word;
            $sub .= $part;
            $len += strlen($part);

            if (strlen($word) > $minword && strlen($sub) >= $length) {
                break;
            }
        }

        return $sub . (($len < strlen($str)) ? '...' : '');
    }

    
    /**
     * Confert a complete html page to simple text
     * 
     * @param string $string
     * @return string
     */
    public static function html_to_text($string)
    {

        $search = array(
            "'<script[^>]*?>.*?</script>'si", // Strip out javascript
            "'<[\/\!]*?[^<>]*?>'si", // Strip out html tags
            "'([\r\n])[\s]+'", // Strip out white space
            "'&(quot|#34);'i", // Replace html entities
            "'&(amp|#38);'i",
            "'&(lt|#60);'i",
            "'&(gt|#62);'i",
            "'&(nbsp|#160);'i",
            "'&(iexcl|#161);'i",
            "'&(cent|#162);'i",
            "'&(pound|#163);'i",
            "'&(copy|#169);'i",
            "'&(reg|#174);'i",
            "'&#8482;'i",
            "'&#149;'i",
            "'&#151;'i",
            "'&#(\d+);'e"
        );  // evaluate as php

        $replace = array(
            " ",
            " ",
            "\\1",
            "\"",
            "&",
            "<",
            ">",
            " ",
            "&iexcl;",
            "&cent;",
            "&pound;",
            "&copy;",
            "&reg;",
            "<sup><small>TM</small></sup>",
            "&bull;",
            "-",
            "uchr(\\1)"
        );

        $text = preg_replace($search, $replace, $string);
        return $text;
    }

    
    
    /**
     * Replace a sentence excluding it if is included into a given html tag
     * 
     * @param string $find_str
     * @param string $replace_str
     * @param string $string
     * @return string
     */
    public static function replace_not_in_tags($find_str, $replace_str, $string)
    {

        $find = array($find_str);
        $replace = array($replace_str);
        preg_match_all('#[^>]+(?=<)|[^>]+$#', $string, $matches, PREG_SET_ORDER);
        foreach ($matches as $val)
        {
            if (trim($val[0]) != "") {
                $string = str_replace($val[0], str_replace($find, $replace, $val[0]), $string);
            }
        }
        return $string;
    }

    
    /**
     * Return true if the parameter is encoded with utf8 charset
     * 
     * @param string $text
     * @return string
     */
    public static function isUTF8($text)
    {
        $res = mb_detect_encoding($text);
        return $res == "UTF-8" || $res == "ASCII";
    }

    /**
     * Return an array of $object_class. If the key_field
     * is set the array will be set with that field as array key
     * 
     * The object must extends DbMySql_initializer or DbMySql_Persister
     * 
     * <pre>
     * require_once("DbMySql_initializer.php");
     * class <b>User</b> extends <b>DbMySql_initializer</b>
     * {
     *      public $Host;
     *      public $User;    
     * };
     * 
     * $sql = "SELECT * FROM user";
     * $els = PhpUtils::getObjectsFromResults(mysql_query($sql), "User");
     * foreach($els as $user)
     * {
     *     echo $user->User;
     *     echo "&lt;br /&gt;";
     * }
     * </pre>
     * 
     * @param mysql resultset $rs
     * @param string $object_class (Just the class name)
     * @param boolean $key_field
     * 
     * @return array 
     */
    public static function getObjectsFromResults($rs, $object_class, $key_field = false)
    {
        $obj_array = array();
        while ($row = mysql_fetch_object($rs))
        {
            //Load class
            $class = new $object_class();
            $class->initialize($row);
            if ($key_field !== false) {
                $obj_array[$class->$key_field] = $class;
            } else {
                $obj_array[] = $class;
            }
        }

        return $obj_array;
    }

    
    /**
     * Try to close from unclear html all unclosed tags
     * 
     * @param string $unclosedString
     * @return string
     */
    public static function closeUnclosedTags($unclosedString)
    {

        preg_match_all("/<([^\/]\w*)>/", $closedString = $unclosedString, $tags);
        for ($i = count($tags[1]) - 1; $i >= 0; $i--)
        {
            $tag = $tags[1][$i];
            if (substr_count($closedString, "</$tag>") < substr_count($closedString, "<$tag>")) {
                $closedString .= "</$tag>";
            }
        }
        return $closedString;
    }

    
    
    /**
     * Compress a buffer string
     * 
     * @param string $buffer
     * @return string
     */
    public static function compress_output($buffer)
    {

        $search = array(
            '/\>[^\S ]+/s', //strip whitespaces after tags, except space
            '/[^\S ]+\</s', //strip whitespaces before tags, except space
            '/(\s)+/s' // shorten multiple whitespace sequences
        );
        $replace = array(
            '>',
            '<',
            '\\1'
        );
        $buffer = preg_replace($search, $replace, $buffer);


        return $buffer;
    }

    
    /**
     * Return a clean string for an Rss output
     * 
     * @param string $buffer
     * @return string
     */   
    public static function cleanupRss($buffer)
    {
        $buffer = html_entity_decode(strip_tags($buffer));
        $buffer = utf8_encode(ltrim(rtrim(str_replace(array(">", "<", "\"", "\n", "\r", "\t", "&nbsp;", "  "), " ", $buffer))));

        $buffer = str_replace(array("&"), "e", $buffer);
        return $buffer;
    }

    
    /**
     * Return the days different between two mysql dates
     * @param string $mysqlDate1
     * @param string $mysqlDate2
     * @return boolean
     */
    public static function getDaysDifferences($mysqlDate1, $mysqlDate2)
    {
        if (empty($mysqlDate1) || empty($mysqlDate2))
            return false;

        $date1 = mktime(0, 0, 0, getMonth($mysqlDate1), getDay($mysqlDate1), getYear($mysqlDate1));
        $date2 = mktime(0, 0, 0, getMonth($mysqlDate2), getDay($mysqlDate2), getYear($mysqlDate2));
        $dateDiff = $date1 - $date2;
        $fullDays = floor($dateDiff / (60 * 60 * 24));
        return $fullDays;
    }


    /**
     * Take off all not utf8 recognised chars from a string
     * 
     * @param string $string
     * @return string
     */
    public static function takeOffNoUTF8Chars($string)
    {
        return preg_replace('/[^(\x20-\x7F)]*/', '', $string);
    }

    
    /**
     * Return the file extension from his name
     * 
     * @param string $filename
     * @return string
     */
    public static function getFileExtension($filename)
    {
        $filename = strtolower($filename);
        $exts = substr($filename, strrpos($filename, ".") + 1);
        return $exts;
    }
    
    /**
     * Take off the extension from the given file name
     * 
     * @see self::getFileExtension
     * @param string $filename
     * @return string
     */
    public static function takeOffExtension($filename)
    {
        $extension = self::getFileExtension($filename);
        return str_replace($extension, "", $filename);        
    }

    


    /**
     * Resize an image and overwrite the result image if exists
     * 
     * @param string $sourcefile
     * @param string $destfile
     * @param int $width
     * @param int $height
     * @param boolean $keepNoSetDimensions  if true original width or height will be maintains if not passed
     * @return boolean
     * @throws Exception
     */
    public static function resizeImage($sourcefile, $destfile, $width = 0, $height = 0, $keepNoSetDimensions = true)
    {
        if (file_exists($destfile)) {
            unlink($destfile);
        }
        
        
        if($keepNoSetDimensions) {
            if(empty($width)) {
                $cmd = "identify -format \"%w\" \"$sourcefile\"";
                exec($cmd, $output, $return_var);
                if($return_var === 0 && !empty($output)) {
                    $width = (int) $output[0];
                }
            }
            if(empty($height)) {
                $cmd = "identify -format \"%h\" \"$sourcefile\"";
                exec($cmd, $output, $return_var);
                if($return_var === 0 && !empty($output)) {
                    $height = (int) $output[0];
                }
            }
        }
        
        $cmd = "/usr/bin/convert ";
        $cmd .= " -quality 90 ";        
        $cmd .= " -resize ".$width."x".$height;       
        $cmd .= " \"$sourcefile\" \"$destfile\" 2>&1";

        exec($cmd, $output, $return_var);
        
        return $return_var === 0;
    }
    
    

    /**
     * Comando diretto imagemagick
     * composite -dissolve 15 -tile watermark.png sorgente.jpg destinazione.jpg
     *
     * @note To use it you must have imagemagick installed on your system
     * 
     * @param string $watermarkfile
     * @param string $sourcefile
     * @param string $destfile
     * @param int $dissolve
     * @return boolean
     */
    public static function watermarkImage($watermarkfile, $sourcefile, $destfile, $dissolve = 5)
    {
        $cmd = "/usr/bin/composite -dissolve $dissolve -tile $watermarkfile $sourcefile $destfile";

        exec($cmd, $output, $return);
        return $return === 0;
    }

    /**
     * Take off the vat value from the given amount
     * 
     * @param double $amount
     * @param float $vat_percent
     * @return double
     */
    public static function vatTakeOff($amount, $vat_percent = 21)
    {
        $el = "1." . $vat_percent;
        $res = ($amount / $el);
        return $res;
    }

    /**
     * Return the amount + the vat 
     * 
     * @param double $amount
     * @param float $vat_percent
     * @return double
     */
    public static function vatGetAmount($amount, $vat_percent = 21)
    {
        return (double) ($amount + (getTaxValue($amount, $vat_percent)));
    }

    /**
     * Return the value of the percentage given for vat
     * 
     * @param double $amount
     * @param float $vat_percent
     * @return double
     */
    public static function vatGetValue($amount, $vat_percent = 21)
    {
        return ($amount * $vat_percent) / 100;
    }

    
    
    /**
     * Search all elements of an array inside another array
     *
     * @param array $arraySearch
     * @param array $arrayValues
     * @return booelan 
     */
    public static function arrays_exists($arraySearch, $arrayValues)
    {
        foreach ($arraySearch as $value)
        {
            if (in_array($value, $arrayValues))
                return true;
        }

        return false;
    }

    
    /**
     * Take off all new lines and tabs converting them into spaces
     * and remove all duplicated spaces from a result string
     * 
     * @param string $str
     * @return string
     */
    public static function remove_double_spaces($str)
    {
        $str = str_replace("\t", "  ", $str);
        $str = str_replace("\n", "  ", $str);
        $str = str_replace("\r", "  ", $str);
        $str = str_replace("\r\n", "  ", $str);

        while (strpos($str, "  ") !== false)
        {
            $str = str_replace("  ", " ", $str);
        }

        return trim($str);
    }

    
    /**
     * Return the hostname from an $ipaddress
     * 
     * @note to use this function it must be installed the getent command on the system
     * 
     * @param string $ipaddress
     * @return string
     */
    public static function gethost($ipaddress)
    {
        $host = trim(`getent hosts $ipaddress`);
        $host = explode(" ", $host);
        if (isset($host[1]))
            return $host[1];
        else
            return "";
    }

    /**
     * like number_format($value, 2, "," , ".")
     */
    public static function nf($number, $decimals = 2)
    {
        $number = (double) $number;
        return number_format($number, $decimals, ",", ".");
    }

    /**
     * like number_format($value, 2, "." , "")
     */
    public static function nf_db($number, $decimals = 2)
    {
        $number = (double) $number;
        return number_format($number, $decimals, ".", "");
    }

    /**
     * Take off double quotes at the first and the last position
     * of the given value
     * 
     * @param string $value
     * @return string
     */
    public static function takeOffQuotes($value)
    {
        $value = trim($value);

        if (substr($value, 0, 1) == "\"") {
            $value = substr($value, 1, strlen($value) - 2);
        }

        return $value;
    }

    

    /**
     * Convert a number from x.xxx,xx to xxxx.xx
     *
     * @param string $value
     * @return string
     */
    public static function toMySqlNumber($value)
    {
        if (strpos($value, ",") === false)
            return $value;

        $value = str_replace(".", "", $value);
        $value = str_replace(",", ".", $value);

        return $value;
    }

    
    /**
     * Force the browser to render the output as an msexcel file
     * 
     * @param string $data
     * @param string $filename
     */
    public static function toExcel($data, $filename)
    {
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: inline; filename=$filename");

        exit(utf8_decode($data));
    }

    /**
     * Force the browser to render the output as an msword file
     * 
     * @param string $data
     * @param string $filename
     */
    public static function toWord($data, $filename)
    {
        header("Content-Type: application/vnd.ms-word");
        header("Content-Disposition: inline; filename=$filename");
        exit(utf8_decode($data));
    }

    /**
     * Validate a string as a EAN13 bar code
     * 
     * Just an alias to validate_EAN13Barcode
     *
     * @see self::validate_EAN13Barcode
     * 
     * @param string $barcode
     * @return boolean
     */
    public static function isValidEan($barcode)
    {
        return validate_EAN13Barcode($barcode);
    }

    /**
     * Validate a string as a EAN13 bar code
     * 
     * @see self::isValidEan
     * 
     * @param string $barcode
     * @return boolean
     */
    public static function validate_EAN13Barcode($barcode)
    {
        // check to see if barcode is 13 digits long
        if (!preg_match("/^[0-9]{13}$/", $barcode)) {
            return false;
        }


        $digits = $barcode;

        // 1. Add the values of the digits in the even-numbered positions: 2, 4, 6, etc.
        $even_sum = $digits[1] + $digits[3] + $digits[5] + $digits[7] + $digits[9] + $digits[11];
        // 2. Multiply this result by 3.
        $even_sum_three = $even_sum * 3;
        // 3. Add the values of the digits in the odd-numbered positions: 1, 3, 5, etc.
        $odd_sum = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8] + $digits[10];
        // 4. Sum the results of steps 2 and 3.
        $total_sum = $even_sum_three + $odd_sum;
        // 5. The check character is the smallest number which, when added to the result in step 4, produces a multiple of 10.
        $next_ten = (ceil($total_sum / 10)) * 10;
        $check_digit = $next_ten - $total_sum;

        // if the check digit and the last digit of the barcode are OK return true;
        if ($check_digit == $digits[12]) {
            return true;
        }

        return false;
    }

    
    /**
     * Validate a string as a UPCA bar code
     * 
     * @param string $barcode
     * @return boolean
     */
    public static function validate_UPCABarcode($barcode)
    {
        // check to see if barcode is 12 digits long
        if (!preg_match("/^[0-9]{12}$/", $barcode)) {
            return false;
        }

        $digits = $barcode;
        // 1. sum each of the odd numbered digits
        $odd_sum = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8] + $digits[10];
        // 2. multiply result by three
        $odd_sum_three = $odd_sum * 3;
        // 3. add the result to the sum of each of the even numbered digits
        $even_sum = $digits[1] + $digits[3] + $digits[5] + $digits[7] + $digits[9];
        $total_sum = $odd_sum_three + $even_sum;
        // 4. subtract the result from the next highest power of 10
        $next_ten = (ceil($total_sum / 10)) * 10;
        $check_digit = $next_ten - $total_sum;

        // if the check digit and the last digit of the barcode are OK return true;
        if ($check_digit == $digits[11]) {
            return true;
        }
        return false;
    }

    
    /**
     * Get the domain name from the given url
     * return false if the url is not a correct address
     * 
     * @param string $url
     * @return string
     */
    public static function getDomain($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED) === FALSE) {
            return false;
        }
        /*         * * get the url parts ** */
        $parts = parse_url($url);
        /*         * * return the host domain ** */
        return $parts['scheme'] . '://' . $parts['host'];
    }

    
    /**
     * Get the domain name from the given email
     * Return false if is not a valid email address
     * 
     * @param string $email
     * @return string
     */
    public static function getEmailDomain($email)
    {
        if (!self::isValidEmail ($email)) return false;
        $parts = explode("@", $email);
        return $parts[1];
    }

    /**
     * @note Only for linux systems
     * 
     * Return the dir size using che system command:
     * du -s
     * 
     * @param type $path
     * @return type
     */
    public static function getdirsize($path)
    {
        $result = explode("\t", exec("du -s " . $path), 2);
        return (@$result[1] == $path ? @$result[0] : "error");
    }

    
    /**
     * Print a message on screen with his formatted lines
     * using the pre html tag and die
     * 
     * @see self::echo_msg
     * @param string $msg
     */
    public static function die_msg($msg)
    {
        echo_msg($msg);
        die();
    }

    /**
     * Print a message on screen with his formatted lines
     * using the pre html tag
     * 
     * @param string $msg
     */
    public static function echo_msg($msg)
    {
        echo "<pre>";
        echo $msg;
        echo "</pre>";
    }

    
    /**
     * Take off bad chars from a filename
     * 
     * @param string $filename
     * @return string
     */
    public static function correctFilename($filename)
    {

        $filename = str_replace("&amp;", "e", $filename);
        $filename = str_replace("è", "e", $filename);
        $filename = str_replace("é", "e", $filename);
        $filename = str_replace("à", "a", $filename);
        $filename = str_replace("ò", "o", $filename);
        $filename = str_replace("ù", "u", $filename);
        $filename = str_replace("ì", "i", $filename);


        $filename = str_replace(" ", "_", $filename);
        $filename = str_replace("'", "", $filename);
        $filename = str_replace("\"", "", $filename);
        $filename = str_replace("/", "-", $filename);
        $filename = str_replace(".", "-", $filename);

        $filename = str_replace(chr(35), "_", $filename); //  #
        $filename = str_replace(chr(36), "_", $filename); //  $
        $filename = str_replace(chr(37), "_", $filename); //  %
        $filename = str_replace(chr(38), "_e_", $filename); //  &
        $filename = str_replace(chr(39), "", $filename); //  '
        $filename = str_replace(chr(40), "_", $filename); //  (
        $filename = str_replace(chr(41), "_", $filename); //  )
        $filename = str_replace(chr(42), "_", $filename); //  *
        $filename = str_replace(chr(43), "_", $filename); //  +
        $filename = str_replace(chr(44), "_", $filename); //  ,
        $filename = str_replace(chr(45), "_", $filename); //  -
        $filename = str_replace(chr(46), "_", $filename); //  .
        $filename = str_replace(chr(47), "_", $filename); //  /
        $filename = str_replace(chr(60), "_", $filename); //  <
        $filename = str_replace(chr(61), "_", $filename); //  =
        $filename = str_replace(chr(62), "_", $filename); //  >
        $filename = str_replace(chr(63), "_", $filename); //  ?
        $filename = str_replace(chr(64), "_", $filename); //  @
        $filename = str_replace(chr(92), "_", $filename); //  \
        $filename = str_replace(chr(93), "_", $filename); //  ]
        $filename = str_replace(chr(94), "_", $filename); //  ^
        $filename = str_replace(chr(95), "_", $filename); //  _
        $filename = str_replace(chr(96), "_", $filename); //  `
        $filename = str_replace(chr(123), "_", $filename); //  {
        $filename = str_replace(chr(124), "_", $filename); //  |
        $filename = str_replace(chr(125), "_", $filename); //  }
        $filename = str_replace(chr(126), "_", $filename); //  ~
        $filename = str_replace(chr(128), "_euro_", $filename); //  €
        $filename = str_replace(chr(130), "_", $filename); //  ‚
        $filename = str_replace(chr(131), "_", $filename); //  ƒ
        $filename = str_replace(chr(132), "_", $filename); //  „
        $filename = str_replace(chr(133), "_", $filename); //  …
        $filename = str_replace(chr(134), "_", $filename); //  †
        $filename = str_replace(chr(135), "_", $filename); //  ‡
        $filename = str_replace(chr(136), "_", $filename); //  ˆ
        $filename = str_replace(chr(137), "_", $filename); //  ‰
        $filename = str_replace(chr(138), "_", $filename); //  Š
        $filename = str_replace(chr(139), "_", $filename); //  ‹
        $filename = str_replace(chr(140), "_", $filename); //  Œ
        $filename = str_replace(chr(142), "_", $filename); //  Ž
        $filename = str_replace(chr(145), "_", $filename); //  ‘
        $filename = str_replace(chr(146), "_", $filename); //  ’
        $filename = str_replace(chr(147), "_", $filename); //  “
        $filename = str_replace(chr(148), "_", $filename); //  ”
        $filename = str_replace(chr(149), "_", $filename); //  •
        $filename = str_replace(chr(150), "_", $filename); //  –
        $filename = str_replace(chr(151), "_", $filename); //  —
        $filename = str_replace(chr(152), "_", $filename); //  ˜
        $filename = str_replace(chr(153), "_", $filename); //  ™
        $filename = str_replace(chr(154), "_", $filename); //  š
        $filename = str_replace(chr(155), "_", $filename); //  ›
        $filename = str_replace(chr(156), "_", $filename); //  œ
        $filename = str_replace(chr(158), "_", $filename); //  ž
        $filename = str_replace(chr(159), "_", $filename); //  Ÿ
        $filename = str_replace(chr(161), "_", $filename); //  ¡
        $filename = str_replace(chr(162), "_", $filename); //  ¢
        $filename = str_replace(chr(163), "_", $filename); //  £
        $filename = str_replace(chr(164), "_", $filename); //  ¤
        $filename = str_replace(chr(165), "_", $filename); //  ¥
        $filename = str_replace(chr(166), "_", $filename); //  ¦
        $filename = str_replace(chr(167), "_", $filename); //  §
        $filename = str_replace(chr(168), "_", $filename); //  ¨
        $filename = str_replace(chr(169), "_", $filename); //  ©
        $filename = str_replace(chr(170), "_", $filename); //  ª
        $filename = str_replace(chr(171), "_", $filename); //  «
        $filename = str_replace(chr(172), "_", $filename); //  ¬
        $filename = str_replace(chr(173), "-", $filename); //  ­
        $filename = str_replace(chr(174), "_", $filename); //  ®
        $filename = str_replace(chr(175), "_", $filename); //  ¯
        $filename = str_replace(chr(176), "_", $filename); //  °
        $filename = str_replace(chr(177), "_", $filename); //  ±
        $filename = str_replace(chr(178), "_", $filename); //  ²
        $filename = str_replace(chr(179), "_", $filename); //  ³
        $filename = str_replace(chr(180), "_", $filename); //  ´
        $filename = str_replace(chr(181), "_", $filename); //  µ
        $filename = str_replace(chr(182), "_", $filename); //  ¶
        $filename = str_replace(chr(183), "_", $filename); //  ·
        $filename = str_replace(chr(184), "_", $filename); //  ¸
        $filename = str_replace(chr(185), "_", $filename); //  ¹
        $filename = str_replace(chr(186), "_", $filename); //  º
        $filename = str_replace(chr(187), "_", $filename); //  »
        $filename = str_replace(chr(188), "_", $filename); //  ¼
        $filename = str_replace(chr(189), "_", $filename); //  ½
        $filename = str_replace(chr(190), "_", $filename); //  ¾
        $filename = str_replace(chr(191), "_", $filename); //  ¿

        $filename = str_replace(chr(192), "A", $filename); //  À
        $filename = str_replace(chr(193), "A", $filename); //  Á
        $filename = str_replace(chr(194), "A", $filename); //  Â
        //$filename = str_replace(chr(195), "A", $filename); //  Ã
        $filename = str_replace(chr(196), "A", $filename); //  Ä
        $filename = str_replace(chr(197), "A", $filename); //  Å
        $filename = str_replace(chr(198), "_", $filename); //  Æ
        $filename = str_replace(chr(199), "C", $filename); //  Ç

        $filename = str_replace(chr(200), "E", $filename); //  È
        $filename = str_replace(chr(201), "E", $filename); //  É
        $filename = str_replace(chr(202), "E", $filename); //  Ê
        $filename = str_replace(chr(203), "E", $filename); //  Ë
        $filename = str_replace(chr(204), "I", $filename); //  Ì
        $filename = str_replace(chr(205), "I", $filename); //  Í
        $filename = str_replace(chr(206), "I", $filename); //  Î
        $filename = str_replace(chr(207), "I", $filename); //  Ï
        $filename = str_replace(chr(208), "D", $filename); //  Ð
        $filename = str_replace(chr(209), "N", $filename); //  Ñ
        $filename = str_replace(chr(210), "O", $filename); //  Ò
        $filename = str_replace(chr(211), "O", $filename); //  Ó
        $filename = str_replace(chr(212), "O", $filename); //  Ô
        $filename = str_replace(chr(213), "O", $filename); //  Õ
        $filename = str_replace(chr(214), "O", $filename); //  Ö
        $filename = str_replace(chr(215), "x", $filename); //  ×
        $filename = str_replace(chr(216), "0", $filename); //  Ø
        $filename = str_replace(chr(217), "U", $filename); //  Ù
        $filename = str_replace(chr(218), "U", $filename); //  Ú
        $filename = str_replace(chr(219), "U", $filename); //  Û
        $filename = str_replace(chr(220), "U", $filename); //  Ü
        $filename = str_replace(chr(221), "Y", $filename); //  Ý
        $filename = str_replace(chr(222), "_", $filename); //  Þ
        $filename = str_replace(chr(223), "B", $filename); //  ß
        $filename = str_replace(chr(224), "a", $filename); //  à
        $filename = str_replace(chr(225), "a", $filename); //  á
        $filename = str_replace(chr(226), "a", $filename); //  â
        $filename = str_replace(chr(227), "a", $filename); //  ã
        $filename = str_replace(chr(228), "a", $filename); //  ä
        $filename = str_replace(chr(229), "a", $filename); //  å
        $filename = str_replace(chr(230), "ae", $filename); //  æ
        $filename = str_replace(chr(231), "c", $filename); //  ç

        $filename = str_replace(chr(232), "e", $filename); //  è
        $filename = str_replace(chr(233), "e", $filename); //  é
        $filename = str_replace(chr(234), "e", $filename); //  ê
        $filename = str_replace(chr(235), "e", $filename); //  ë
        $filename = str_replace(chr(236), "i", $filename); //  ì
        $filename = str_replace(chr(237), "i", $filename); //  í
        $filename = str_replace(chr(238), "i", $filename); //  î
        $filename = str_replace(chr(239), "i", $filename); //  ï
        $filename = str_replace(chr(240), "o", $filename); //  ð
        $filename = str_replace(chr(241), "n", $filename); //  ñ
        $filename = str_replace(chr(242), "o", $filename); //  ò
        $filename = str_replace(chr(243), "o", $filename); //  ó
        $filename = str_replace(chr(244), "o", $filename); //  ô
        $filename = str_replace(chr(245), "o", $filename); //  õ
        $filename = str_replace(chr(246), "o", $filename); //  ö
        $filename = str_replace(chr(247), "_", $filename); //  ÷
        $filename = str_replace(chr(248), "_", $filename); //  ø
        $filename = str_replace(chr(249), "u", $filename); //  ù
        $filename = str_replace(chr(250), "u", $filename); //  ú
        $filename = str_replace(chr(251), "u", $filename); //  û
        $filename = str_replace(chr(252), "u", $filename); //  ü
        $filename = str_replace(chr(253), "y", $filename); //  ý
        $filename = str_replace(chr(254), "_", $filename); //  þ
        $filename = str_replace(chr(255), "y", $filename); //  ÿ


        while (strpos($filename, "__") !== false)
        {
            $filename = str_replace("__", "_", $filename);
        }

        if (substr($filename, strlen($filename) - 1) == "_") {
            $filename = substr($filename, 0, strlen($filename) - 1);
        }

        return $filename;
    }

    
    /**
     * Convert all variables into $_POST in lowercase
     * 
     * @param boolean $nomail       if true exclude email address
     * @param array $arrayToIgnore  if not empty exclude elements from the operation
     * 
     */
    public static function strToLowerPostVariabiles($nomail = true, $arrayToIgnore = array())
    {
        foreach ($_POST as $key => $value)
        {
            if ($nomail && strpos($value, "@") !== false)
                continue;

            if (in_array($key, $arrayToIgnore))
                continue;

            $_POST[$key] = trim(strtolower($value));
        }
    }

    /**
     * Convert all variables into $_POST in uppercase
     * 
     * @param boolean $nomail       if true exclude email address
     * @param array $arrayToIgnore  if not empty exclude elements from the operation
     * 
     */
    public static function strToUpperPostVariabiles($nomail = true, $arrayToIgnore = array())
    {
        foreach ($_POST as $key => $value)
        {
            if ($nomail && strpos($value, "@") !== false)
                continue;

            if (in_array($key, $arrayToIgnore))
                continue;

            $_POST[$key] = trim(strtoupper($value));
        }
    }

    /**
     * Trim all variables into $_POST
     */
    public static function trimPostVariables()
    {
        foreach ($_POST as $key => $value)
        {
            if (!is_array($value)) {
                $_POST[$key] = trim($value);
            }
        }
    }


    /**
     * Give the today string with eventually including the time
     * 
     * @param boolean $time
     * @return string
     */
    public static function today($time = true)
    {
        return ($time) ? date("Y-m-d H:i:s") : date("Y-m-d");
    }

    
    /**
     * Check if the given url is valid or not
     * 
     * @param string $str
     * @return boolean
     */
    public static function valid_url($str)
    {
        if (empty($str))
            return true;

        if (strpos($str, "http") === false) {
            return false;
        } else {
            return (!preg_match('/^(http|https|ftp)); //\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+)); //?(\d+)?\/?/i', $str)) ? FALSE : TRUE;
        }
    }

    /**
     * @note Only for linux systems
     * 
     * Return the size for a file or directory using the system command du
     * 
     * @param string $uri
     * @param boolean $human_readable_format    if true the function will return a human readable format
     */
    public static function get_file_size($uri = ".", $human_readable_format = true)
    {
        //echo "du -hs $filename";
        $str_return = "0 kb";

        clearstatcache();

        if ($human_readable_format) {
            $str_return = exec("du -hs '$uri'");
        } else {
            $str_return = shell_exec("du -s '$uri'");
        }

        $res = substr($str_return, 0, strpos($str_return, APP_BASE));

        return $res;
    }


    /**
     * Format a date with a mysql format :
     *  YYYY-MM-DD H:I:S
     * 
     * @param int $day
     * @param int $month
     * @param int $year
     * @param int $hours
     * @param int $minutes
     * @param int $seconds
     * @return string       false if errors occurrs
     */
    public static function getMySqlFormattedDate($day, $month, $year, $hours = 0, $minutes = 0, $seconds = 0)
    {
        if (empty($day) || empty($month) || empty($year))
            return false;

        if (strlen($day) == 1)
            $day = "0" . $day;
        if (strlen($month) == 1)
            $month = "0" . $month;

        if (strlen($year) == 1)
            $year = "200" . $year;
        else if (strlen($year) == 2)
            $year = "20" . $year;
        else if (strlen($year) == 3)
            $year = "2" . $year;

        if (empty($hours)) {
            return $year . "-" . $month . "-" . $day;
        } else {
            return $year . "-" . $month . "-" . $day . " " . $hours . ":" . $minutes . ":" . $seconds;
        }
    }

    /**
     * Format a date into mysql format from an european formatted date string
     * 
     * The given string must be a date with one of the following formats (with eventually the time):
     * 
     * dd/mm/yyyy hh:mm:ss
     * dd/mm/yy hh:mm:ss
     * d/mm/yy hh:mm:ss
     *
     */
    public static function getMySqlFormattedDateString($data, $separatoreInput = "/", $separatoreOutput = "-")
    {
       
        if (strpos($data, $separatoreInput) === false) {
            return null;
        }

        $tmp = substr($data, 0, 4);
        if ($tmp >= 2000 && $tmp <= 2200) {
            return $data;
        }

        //Check first if can i get slashes
        $pos_slashes = strpos($data, $separatoreInput);
        if ($pos_slashes === false) {
            return "";
        }

        //Split date from time
        $arrDataOra = explode(" ", $data);

        //Get day month and year
        $arrData = explode($separatoreInput, $arrDataOra[0]);

        //if elements are differents to three it will return empty
        if (count($arrData) != 3) {
            return "";
        }

        $giorno = str_pad($arrData[0], 2, "0", STR_PAD_LEFT);
        if (preg_match("/[\D]/", $giorno))
            return "";
        $mese = str_pad($arrData[1], 2, "0", STR_PAD_LEFT);
        if (preg_match("/[\D]/", $mese))
            return "";
        $anno = str_pad($arrData[2], 2, "0", STR_PAD_LEFT);
        if (preg_match("/[\D]/", $anno))
            return "";

        if (strlen($anno) == 2) {
            $anno = "20" . $anno;
        }

        //return time if it's present
        if (!is_array($arrDataOra)) {
            return $anno . $separatoreOutput . $mese . $separatoreOutput . $giorno . " " . $arrDataOra[1];
        } else {
            return $anno . $separatoreOutput . $mese . $separatoreOutput . $giorno;
        }
    }

    
    /**
     * Return true if february has 29 days
     *
     * @param int $year
     * @return boolean
     */
    public static function isLeapYear($year)
    {
        return checkdate(2, 29, $year);
    }

    /**
     * Return the number of days from the given month and year
     * 
     * @see self::getLastDayOfMonth     just an alias
     * 
     * @param int $month
     * @param int $year (default current year)
     * @return int
     */
    public static function getDaysOfMonth($month, $year = null)
    {
        $month = (int) $month;
        if (empty($year))
            $year = date("Y");

        if ($month == 1 || $month == 3 || $month == 5 || $month == 7 || $month == 8 || $month == 10 || $month == 12) {
            return 31;
        } else if ($month == 4 || $month == 6 || $month == 9 || $month == 11) {
            return 30;
        } else {
            if (self::isLeapYear($year))
                return 29;
            else
                return 28;
        }
    }

    /**
     * Return the number of days from the given month and year
     *
     * @see self::getDaysForMonth     just an alias
     * 
     * 31 per 1/3/5/7/8/10/12
     * 30 per 4/6/9/11
     * 28 o 29 per 2
     *
     * @param int $month
     * @param int $year default current year
     */
    public static function getLastDayOfMonth($month, $year = null)
    {
        return self::getDaysOfMonth($month, $year);
    }

    /**
     * Return the day number from a mysql date
     */
    public static function getDay($mySqlDate)
    {

        if (empty($mySqlDate) || $mySqlDate <= 0)
            return "";

        $dati = explode("-", $mySqlDate);
        return trim(substr($dati[2], 0, 2));
    }

    /**
     * Return the month number from a mysql date
     */
    public static function getMonth($mySqlDate)
    {
        if (empty($mySqlDate) || $mySqlDate <= 0)
            return "";

        $dati = explode("-", $mySqlDate);
        return trim(substr($dati[1], 0, 2));
    }

    /**
     * Return the year number from a mysql date
     */
    public static function getYear($mySqlDate)
    {
        if (empty($mySqlDate) || $mySqlDate <= 0)
            return "";

        $dati = explode("-", $mySqlDate);
        return trim(substr($dati[0], 0, 4));
    }

    /**
     * Return the hours value from a mysql date
     */
    public static function getHours($mySqlDate)
    {
        if (empty($mySqlDate) || $mySqlDate <= 0)
            return "";

        if (strpos($mySqlDate, ":") !== false) {
            $dati = explode(" ", $mySqlDate);

            if (empty($dati[1])) {
                $dati[1] = $dati[0];
            }

            $arrOraMinutiSecondi = explode(":", $dati[1]);
            return $arrOraMinutiSecondi[0];
        } else {
            return "";
        }
    }

    /**
     * Return the minutes value from a mysql date
     */
    public static function getMinutes($mySqlDate)
    {
        if (empty($mySqlDate) || $mySqlDate <= 0)
            return "";

        if (strpos($mySqlDate, ":") !== false) {

            $dati = explode(" ", $mySqlDate);

            if (empty($dati[1])) {
                $dati[1] = $dati[0];
            }


            $arrOraMinutiSecondi = explode(":", $dati[1]);
            return $arrOraMinutiSecondi[1];
        } else {
            return "";
        }
    }

    /**
     * Return the seconds value from a mysql date
     * 
     * @param string $mySqlDate
     * @return string
     */
    public static function getSeconds($mySqlDate)
    {
        if (empty($mySqlDate) || $mySqlDate <= 0)
            return "";


        if (strpos($mySqlDate, ":") !== false) {

            $dati = explode(" ", $mySqlDate);

            if (empty($dati[1])) {
                $dati[1] = $dati[0];
            }

            $arrOraMinutiSecondi = explode(":", $dati[1]);
            return $arrOraMinutiSecondi[2];
        } else {
            return false;
        }
    }

    /**
     * Return an european date format from a mysql format date
     * 
     * @param string $mySqlDate
     * @param boolean $printTime        if true print the time if exists
     * @param boolean $excludeMillis    if true exclude milliseconds from time
     * 
     */
    public static function getDateTime($mySqlDate, $printTime = true, $excludeMillis = false)
    {
        if (strpos($mySqlDate, ":") !== false) {

            $dati = explode(" ", $mySqlDate);
            if (getDay($mySqlDate) == "") {
                return false;
            }

            if ($dati[1] == "00:00:00") {
                $dati[1] = "";
            }

            $data = getDay($mySqlDate) . "/" . getMonth($mySqlDate) . "/" . getYear($mySqlDate);
            if ($printTime) {
                if ($excludeMillis) {
                    $orari = explode(":", $dati[1]);
                    $data .= " " . $orari[0] . ":" . $orari[1];
                } else {
                    $data .= " " . $dati[1];
                }
            }

            return ($data == "00/00/0000") ? "" : $data;
        } else {

            if (getDay($mySqlDate) == "") {
                return false;
            }


            $data = getDay($mySqlDate) . "/" . getMonth($mySqlDate) . "/" . getYear($mySqlDate);

            return ($data == "00/00/0000") ? "" : $data;
        }
    }

    /**
     * Print a javascript alert
     */
    public static function alert($msg)
    {
        echo "<script type='text/javascript' >alert('" . addslashes($msg) . "');</script>\n";
    }

    /**
     * Close the current window and eventually reload the operner
     * 
     * @param boolean $reload_opener
     */
    public static function window_close($reload_opener = false)
    {

        if (!$reload_opener) {
            echo "<script  type=\"text/javascript\" >\nwindow.self.close()\n</script>\n";
        } else {
            echo "<script type=\"text/javascript\" >\nwindow.opener.location.reload(true);window.self.close()\n</script>\n";
        }
    }

    

    /**
     * This function validate a correct fiscal code
     * (tested with italian structures)
     * 
     * @param string $cf 
     * @return boolean 
     */
    public static function isValidFiscalCode($cf)
    {

        if ($cf == '')
            return true;

        if (strlen($cf) != 16)
            return false;
        $cf = strtoupper($cf);
        if (!ereg("^[A-Z0-9]+$", $cf)) {
            return false;
        }
        $s = 0;
        for ($i = 1; $i <= 13; $i += 2)
        {
            $c = $cf[$i];
            if ('0' <= $c && $c <= '9')
                $s += ord($c) - ord('0');
            else
                $s += ord($c) - ord('A');
        }
        for ($i = 0; $i <= 14; $i += 2)
        {
            $c = $cf[$i];
            switch ($c)
            {
                case '0': $s += 1;
                    break;
                case '1': $s += 0;
                    break;
                case '2': $s += 5;
                    break;
                case '3': $s += 7;
                    break;
                case '4': $s += 9;
                    break;
                case '5': $s += 13;
                    break;
                case '6': $s += 15;
                    break;
                case '7': $s += 17;
                    break;
                case '8': $s += 19;
                    break;
                case '9': $s += 21;
                    break;
                case 'A': $s += 1;
                    break;
                case 'B': $s += 0;
                    break;
                case 'C': $s += 5;
                    break;
                case 'D': $s += 7;
                    break;
                case 'E': $s += 9;
                    break;
                case 'F': $s += 13;
                    break;
                case 'G': $s += 15;
                    break;
                case 'H': $s += 17;
                    break;
                case 'I': $s += 19;
                    break;
                case 'J': $s += 21;
                    break;
                case 'K': $s += 2;
                    break;
                case 'L': $s += 4;
                    break;
                case 'M': $s += 18;
                    break;
                case 'N': $s += 20;
                    break;
                case 'O': $s += 11;
                    break;
                case 'P': $s += 3;
                    break;
                case 'Q': $s += 6;
                    break;
                case 'R': $s += 8;
                    break;
                case 'S': $s += 12;
                    break;
                case 'T': $s += 14;
                    break;
                case 'U': $s += 16;
                    break;
                case 'V': $s += 10;
                    break;
                case 'W': $s += 22;
                    break;
                case 'X': $s += 25;
                    break;
                case 'Y': $s += 24;
                    break;
                case 'Z': $s += 23;
                    break;
            }
        }
        if (chr($s % 26 + ord('A')) != $cf[15])
            return false;

        return true;
    }

    
    /**
     * This function validate a vat code
     * (tested with italian structures)
     * 
     * @param string $code
     * @return boolean 
     */
    public static function isValidVatCode($code)
    {
        if ($code == '')
            return true;
        if (strlen($code) != 11)
            return false;

        if (!preg_match("/^[0-9]+$/", $code)) {
            return false;
        }

        $s = 0;
        for ($i = 0; $i <= 9; $i += 2)
            $s += ord($code[$i]) - ord('0');
        for ($i = 1; $i <= 9; $i += 2)
        {
            $c = 2 * ( ord($code[$i]) - ord('0') );
            if ($c > 9)
                $c = $c - 9;
            $s += $c;
        }
        if (( 10 - $s % 10 ) % 10 != ord($code[10]) - ord('0'))
            return false;
        return true;
    }

    
    /**
     * Simple email validation
     * 
     * @param string $email
     * @return boolean
     */
    public static function isValidEmail($email)
    {
        return preg_match("/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/", $email);
    }

    /**
     * Convert an object to an array associating all class members
     * 
     * @param class $object
     * @return array
     */
    public static function objectToArray($object)
    {

        if (is_array($object))
            return $object;

        if (!is_object($object))
            return false;

        $serial = serialize($object);
        $serial = preg_replace('/O:\d+:".+?"/', 'a', $serial);
        if (preg_match_all('/s:\d+:"\\0.+?\\0(.+?)"/', $serial, $ms, PREG_SET_ORDER)) {
            foreach ($ms as $m)
            {
                $serial = str_replace($m[0], 's:' . strlen($m[1]) . ':"' . $m[1] . '"', $serial);
            }
        }

        return @unserialize($serial);
    }

}

?>
