<?php
namespace App\Helpers;
class Helpers {

    /*==================================================
        ARRAY HELPERS
    ====================================================*/
    public static function array_to_pipes($array)
    {
        //if passed value is an array
        if (is_array($array)) {
            return '|' . implode('|', $array) . '|';
        } else {
            return FALSE;
        }

    }

    public static function pipes_to_array($piped_string)
    {
        //do only if a string is passed
        if ($piped_string) {
            $tags = explode('|', $piped_string);
            $array_values = array();

            foreach ($tags as $tag) {
                //save only tags with values
                if ($tags <> '' && !in_array($tag, $array_values)) {
                    $array_values[] = $tag;
                }
            }

            return $array_values;
        } else {
            return NULL;
        }

    }

    /**
     * Formats a line (passed as a fields  array) as CSV and returns the CSV as a string.
     * Adapted from http://us3.php.net/manual/en/function.fputcsv.php#87120
     */
    public static function array_to_csv(array &$fields, $delimiter = ',', $enclosure = '"', $encloseAll = false, $nullToMysqlNull = false)
    {
        $delimiter_esc = preg_quote($delimiter, '/');
        $enclosure_esc = preg_quote($enclosure, '/');

        $output = array();
        foreach ($fields as $field) {
            if ($field === null && $nullToMysqlNull) {
                $output[] = 'NULL';
                continue;
            }

            // Enclose fields containing $delimiter, $enclosure or whitespace
            if ($encloseAll || preg_match("/(?:${delimiter_esc}|${enclosure_esc}|\s)/", $field)) {
                $output[] = $enclosure . str_replace($enclosure, $enclosure . $enclosure, $field) . $enclosure;
            } else {
                $output[] = $field;
            }
        }

        return implode($delimiter, $output);
    }

    public static function csv_to_array($myString)
    {
        return explode(',', $myString);
    }

//print an array
    public static function print_array($array)
    {
        print '<pre>';
        print_r($array);
        print '</pre>';
    }




    /*==================================================
        BOOTSTRAP HELPERS
    ====================================================*/
    public static function error_template($msg)
    {

        ?>
        <div class="alert-message alert-message-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">�</button>

            <p>
                <?= $msg ?></p>
        </div>
        <?php
    }

    public static function success_template($msg)
    {

        ?>
        <div class="alert-message alert-message-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">�</button>

            <p>
                <?= $msg ?></p>
        </div>
        <?php
    }

    public static function warning_template($msg)
    {

        ?>
        <div class="alert-message alert-message-warning">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">�</button>

            <p>
                <?= $msg ?></p>
        </div>

        <?php
    }

    public static function info_template($msg)
    {

        ?>
        <div class="alert-message alert-message-info">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">�</button>

            <p>
                <?= $msg ?></p>
        </div>
        <?php
    }

    public static function bootstrap_panel_basic($content)
    {

        ?>
        <div class="panel">
            <div class="panel-body"><?= $content ?></div>
        </div>
        <?php
    }

    public static function bootstrap_panel_primary($content)
    {

        ?>
        <div class="panel panel-primary">
            <div class="panel-body"><?= $content ?></div>
        </div>
        <?php
    }

    public static function bootstrap_panel_primary_with_heading($heading, $content)
    {

        ?>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4><?= $heading ?></h4>

                <div class="options">
                    <a class="panel-collapse" href="#">
                        <i class="fa fa-chevron-down"></i></a>
                </div>
            </div>
            <div class="panel-body"><?= $content ?></div>
        </div>
        <?php
    }



    /*==================================================
        DATETIME HELPERS
    ====================================================*/
    public static function seconds_to_days($mysec)
    {
        $mysec = (int)$mysec;
        if ($mysec === 0) {
            return '0 second';
        }

        $mins = 0;
        $hours = 0;
        $days = 0;


        if ($mysec >= 60) {
            $mins = (int)($mysec / 60);
            $mysec = $mysec % 60;
        }
        if ($mins >= 60) {
            $hours = (int)($mins / 60);
            $mins = $mins % 60;
        }
        if ($hours >= 24) {
            $days = (int)($hours / 24);
            $hours = $hours % 60;
        }

        $output = '';

        if ($days) {
            $output .= $days . " days ";
        }

        $output = rtrim($output);
        return $output;
    }

    public static function my_date_diff($date1, $date2)
    {
        $datetime1 = new DateTime($date1);
        $datetime2 = new DateTime($date2);
        $interval = $datetime1->diff($datetime2);
        return $interval->format('%R%a days');
    }

    public static function dateDiff($time1, $time2, $precision = 6)
    {
        // If not numeric then convert texts to unix timestamps
        if (!is_int($time1)) {
            $time1 = strtotime($time1);
        }
        if (!is_int($time2)) {
            $time2 = strtotime($time2);
        }

        // If time1 is bigger than time2
        // Then swap time1 and time2
        if ($time1 > $time2) {
            $ttime = $time1;
            $time1 = $time2;
            $time2 = $ttime;
        }

        // Set up intervals and diffs arrays
        $intervals = array('year', 'month', 'day', 'hour', 'minute', 'second');
        $diffs = array();

        // Loop thru all intervals
        foreach ($intervals as $interval) {
            // Create temp time from time1 and interval
            $ttime = strtotime('+1 ' . $interval, $time1);
            // Set initial values
            $add = 1;
            $looped = 0;
            // Loop until temp time is smaller than time2
            while ($time2 >= $ttime) {
                // Create new temp time from time1 and interval
                $add++;
                $ttime = strtotime("+" . $add . " " . $interval, $time1);
                $looped++;
            }

            $time1 = strtotime("+" . $looped . " " . $interval, $time1);
            $diffs[$interval] = $looped;
        }

        $count = 0;
        $times = array();
        // Loop thru all diffs
        foreach ($diffs as $interval => $value) {
            // Break if we have needed precission
            if ($count >= $precision) {
                break;
            }
            // Add value and interval
            // if value is bigger than 0
            if ($value > 0) {
                // Add s if value is not 1
                if ($value != 1) {
                    $interval .= "s";
                }
                // Add value and interval to times array
                $times[] = $value . " " . $interval;
                $count++;
            }
        }

        // Return string with times
        return implode(", ", $times);
    }

    public static function check_in_range($start_date, $end_date, $date_from_user)
    {
        // Convert to timestamp
        $start_ts = strtotime($start_date);
        $end_ts = strtotime($end_date);
        $user_ts = strtotime($date_from_user);

        // Check that user date is between start & end
        return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
    }

    public static function to_date_picker_format($date)
    {
        return custom_date_format('m/d/Y', $date);
    }


    public static function difference_in_days($date_1, $date_2)
    {

        $date1 = strtotime($date_1);
        $date2 = strtotime($date_2);
        $dateDiff = $date1-$date2;
        return floor($dateDiff/(60*60*24));

    }

    public static function get_age($date)
    {
        //do nothing if if nothing is passed
        if ($date) {
            $c = date('Y');
            $y = date('Y', strtotime($date));
            return $c - $y;
        }

    }

    public static function seconds2days($mysec)
    {
        $mysec = (int)$mysec;
        if ($mysec === 0) {
            return '0 second';
        }

        $mins = 0;
        $hours = 0;
        $days = 0;


        if ($mysec >= 60) {
            $mins = (int)($mysec / 60);
            $mysec = $mysec % 60;
        }
        if ($mins >= 60) {
            $hours = (int)($mins / 60);
            $mins = $mins % 60;
        }
        if ($hours >= 24) {
            $days = (int)($hours / 24);
            $hours = $hours % 60;
        }

        $output = '';

        if ($days) {
            $output .= $days . " days ";
        }
        if ($hours) {
            $output .= $hours . " hours ";
        }
        if ($mins) {
            $output .= $mins . " minutes ";
        }
        if ($mysec) {
            $output .= $mysec . " seconds ";
        }
        $output = rtrim($output);
        return $output;
    }

    public static function time_ago($date)
    {


        $time_ago = strtotime($date);
        $cur_time = time();
        $time_elapsed = $cur_time - $time_ago;
        $seconds = $time_elapsed;
        $minutes = round($time_elapsed / 60);
        $hours = round($time_elapsed / 3600);
        $days = round($time_elapsed / 86400);
        $weeks = round($time_elapsed / 604800);
        $months = round($time_elapsed / 2600640);
        $years = round($time_elapsed / 31207680);
// Seconds
        if ($seconds <= 60) {
            echo "$seconds seconds ago";
        } //Minutes
        else if ($minutes <= 60) {
            if ($minutes == 1) {
                echo "one minute ago";
            } else {
                echo "$minutes minutes ago";
            }
        } //Hours
        else if ($hours <= 24) {
            if ($hours == 1) {
                echo "an hour ago";
            } else {
                echo "$hours hours ago";
            }
        } //Days
        else if ($days <= 7) {
            if ($days == 1) {
                echo "yesterday";
            } else {
                echo "$days days ago";
            }
        } //Weeks
        else if ($weeks <= 4.3) {
            if ($weeks == 1) {
                echo "a week ago";
            } else {
                echo "$weeks weeks ago";
            }
        } //Months
        else if ($months <= 12) {
            if ($months == 1) {
                echo "a month ago";
            } else {
                echo "$months months ago";
            }
        } //Years
        else {
            if ($years == 1) {
                echo "one year ago";
            } else {
                echo "$years years ago";
            }
        }

    }


//seconds to time
    public static function Sec2Time($time)
    {
        if (is_numeric($time)) {
            $value = array(
                "years" => 0, "days" => 0, "hours" => 0,
                "minutes" => 0, "seconds" => 0,
            );
            if ($time >= 31556926) {
                $value["years"] = floor($time / 31556926);
                $time = ($time % 31556926);
            }
            if ($time >= 86400) {
                $value["days"] = floor($time / 86400);
                $time = ($time % 86400);
            }
            if ($time >= 3600) {
                $value["hours"] = floor($time / 3600);
                $time = ($time % 3600);
            }
            if ($time >= 60) {
                $value["minutes"] = floor($time / 60);
                $time = ($time % 60);
            }
            $value["seconds"] = floor($time);
            return (array)$value;
        } else {
            return (bool)FALSE;
        }
    }

//hu,am friendly date now
    public static function human_date_today()
    {
        /*
         * other options
         *
    $today = date("F j, Y, g:i a");                   // March 10, 2001, 5:16 pm
    $today = date("m.d.y");                           // 03.10.01
    $today = date("j, n, Y");                         // 10, 3, 2001
    $today = date("Ymd");                             // 20010310
    $today = date('h-i-s, j-m-y, it is w Day');       // 05-16-18, 10-03-01, 1631 1618 6 Satpm01
    $today = date('\i\t \i\s \t\h\e jS \d\a\y.');     // It is the 10th day (10�me jour du mois).
    $today = date("D M j G:i:s T Y");                 // Sat Mar 10 17:16:18 MST 2001
    $today = date('H:m:s \m \e\s\t\ \l\e\ \m\o\i\s'); // 17:03:18 m est le mois
    $today = date("H:i:s");                           // 17:16:18
    $today = date("Y-m-d H:i:s");                     // 2001-03-
         */

        return date('l jS F Y');
    }

//to formate date for mysql
    public static function mysqldate()
    {
        $mysqldate = date("m/d/y g:i A", now());
        $phpdate = strtotime($mysqldate);
        return date('Y-m-d H:i:s', $phpdate);
    }

//date to seconds
    public static function date_to_seconds($date)
    {
        return strtotime($date);
    }

    public static function database_ready_format($date)
    {
        $mysqldate = date("m/d/y g:i A", strtotime($date));
        $phpdate = strtotime($mysqldate);
        return date('Y-m-d H:i:s', $phpdate);
    }

    public static function custom_date_format($format = 'd.F.Y', $date = '')
    {
        $date = strtotime($date);
        return date($format, $date);
    }

    public static function system_date_format($date = '')
    {
        $date = strtotime($date);
        return date(Config::get('constants.dateformat'), $date);
    }

    public static function get_month($number)
    {
        $month = '';
        foreach (months_array() as $key => $value) {

            if ($key == $number) {
                $month = $value;
            }


        }
        return $month;
    }

    public static function age_from_dob($dob)
    {
        $dob = strtotime($dob);
        $y = date('Y', $dob);
        if (($m = (date('m') - date('m', $dob))) < 0) {
            $y++;
        } elseif ($m == 0 && date('d') - date('d', $dob) < 0) {
            $y++;
        }
        return date('Y') - $y;
    }



    /*==================================================
        FOLDER HELPERS
    ====================================================*/
    public static function emptyDirectory($dirname, $self_delete = false)
    {
        if (is_dir($dirname))
            $dir_handle = opendir($dirname);
        if (!$dir_handle)
            return false;
        while ($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirname . "/" . $file))
                    @unlink($dirname . "/" . $file);
                else
                    emptyDirectory($dirname . '/' . $file, true);
            }
        }
        closedir($dir_handle);
        if ($self_delete) {
            @rmdir($dirname);
        }
        return true;
    }

    public static function deleteDirectory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }

        }


        return rmdir($dir);
    }

    /* creates a compressed zip file */
    public static function create_zip($files = array(), $destination = '', $overwrite = false)
    {
        //if the zip file already exists and overwrite is false, return false
        if (file_exists($destination) && !$overwrite) {
            return false;
        }
        //vars
        $valid_files = array();
        //if files were passed in...
        if (is_array($files)) {
            //cycle through each file
            foreach ($files as $file) {
                //make sure the file exists
                if (file_exists($file)) {
                    $valid_files[] = $file;
                }
            }
        }
        //if we have good files...
        if (count($valid_files)) {
            //create the archive
            $zip = new ZipArchive();
            if ($zip->open($destination, $overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
                return false;
            }
            //add the files
            foreach ($valid_files as $file) {
                $zip->addFile($file, $file);
            }
            //debug
            //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;

            //close the zip -- done!
            $zip->close();

            //check to make sure the file exists
            return file_exists($destination);
        } else {
            return false;
        }
    }


    public static function create_folder($folder_name)
    {

        if (!file_exists($folder_name)) {
            $result = mkdir($folder_name, 0777);
        }
        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }


    public static function delete_all_files_in_directory($path)
    {
        $files = glob($path); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file))
                unlink($file); // delete file
        }
    }

    public static function delete_files_in_directory_v2($target)
    {
        if (is_dir($target)) {
            $files = glob($target . '*', GLOB_MARK); //GLOB_MARK adds a slash to directories returned

            foreach ($files as $file) {
                delete_files($file);
            }

            rmdir($target);
        } elseif (is_file($target)) {
            unlink($target);
        }
    }

    public static function unzip_file($location, $newLocation)
    {
        if (exec("unzip $location", $arr)) {
            mkdir($newLocation);
            for ($i = 1; $i < count($arr); $i++) {
                $file = trim(preg_replace("~inflating: ~", "", $arr[$i]));
                copy($location . '/' . $file, $newLocation . '/' . $file);
                unlink($location . '/' . $file);
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }




    /*==================================================
        IMAGE HELPERS
    ====================================================*/
    public static function is_image($filepath)
    {
        if (@!is_array(getimagesize($filepath))) {
            $image = false;
        } else {
            $image = true;
        }

        return $image;
    }

//check if an image exists
    public static function check_image_existance($path, $image_name)
    {
        //buld the url
        $image_url = $path . $image_name;
        if (file_exists($image_url) !== false) {
            return true;
        }
    }

//delete a file
    public static function delete_image($path, $image_name)
    {
        //images to delete
        $items = array(get_thumbnail($image_name), $image_name);

        //delete only if exists
        foreach ($items as $item) {
            if (check_image_existance($path, $item)) {
                unlink($path . $item);
            }
        }

    }


    /*==================================================
        IPADDRESS HELPERS
    ====================================================*/
//check domain availability
    public static function domain_availability($domains)
    {
        foreach ($domains as $domain) {
            $ns = @dns_get_record($domain, DNS_NS);
            if (count($ns)) {
                $rs[$domain] = 0;
            } else {
                $rs[$domain] = 1;
            }
        }
        return $rs;
    }

//check if there is internet
    public static function check_internet_connection($sCheckHost = 'www.google.com')
    {
        return (bool)@fsockopen($sCheckHost, 80, $iErrno, $sErrStr, 5);
    }

    public static function check_live_server()
    {
        $whitelist = array(
            '127.0.0.1',
            '::1'
        );

        if (!in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

//check if ur on localhost
    public static function check_localhost()
    {
        if ($_SERVER["SERVER_ADDR"] == '127.0.0.1') {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function get_real_ip_address()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public static function getUserAddress($lat, $lng)
    {
        $url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng=' . trim($lat) . ',' . trim($lng) . '&sensor=false';
        $json = @file_get_contents($url);
        $data = json_decode($json);
        $status = $data->status;
        if ($status == "OK")
            return $data->results[0]->formatted_address;
        else
            return false;
    }


    /*==================================================
        NUMBER HELPERS
    ====================================================*/
//round up
    public static function round_up($number, $precision = 0)
    {
        return round($number, $precision, PHP_ROUND_HALF_UP);
    }

//round dowm
    public static function round_down($number, $precision = 0)
    {
        return round($number, $precision, PHP_ROUND_HALF_DOWN);
    }

//round even
    public static function round_even($number, $precision = 0)
    {
        return round($number, $precision, PHP_ROUND_HALF_EVEN);
    }


    /*==================================================
        STRING HELPERS
    ====================================================*/
    public static function trim_text($input, $length, $ellipses = true, $strip_html = true)
    {
        //strip tags, if desired
        if ($strip_html) {
            $input = strip_tags($input);
        }

        //no need to trim, already shorter than trim length
        if (strlen($input) <= $length) {
            return $input;
        }

        //find last space within length
        $last_space = strrpos(substr($input, 0, $length), ' ');
        $trimmed_text = substr($input, 0, $last_space);

        //add ellipses (...)
        if ($ellipses) {
            $trimmed_text .= '...';
        }

        return $trimmed_text;
    }

    public static function generate_password($length = 8, $complex = 3)
    {
        $min = "abcdefghijklmnopqrstuvwxyz";
        $num = "0123456789";
        $maj = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $symb = "!@#$%^&*()_-=+;:,.?";
        $chars = $min;
        if ($complex >= 2) {
            $chars .= $num;
        }
        if ($complex >= 3) {
            $chars .= $maj;
        }
        if ($complex >= 4) {
            $chars .= $symb;
        }
        $password = substr(str_shuffle($chars), 0, $length);
        return $password;
    }

    public static function str_rand($length = 8, $output = 'alphanum')
    {
        // Possible seeds
        $outputs['alpha'] = 'abcdefghijklmnopqrstuvwqyz';
        $outputs['numeric'] = '0123456789';
        $outputs['alphanum'] = 'abcdefghijklmnopqrstuvwqyz0123456789';
        $outputs['hexadec'] = '0123456789abcdef';

        // Choose seed
        if (isset($outputs[$output])) {
            $output = $outputs[$output];
        }

        // Seed generator
        list($usec, $sec) = explode(' ', microtime());
        $seed = (float)$sec + ((float)$usec * 100000);
        mt_srand($seed);

        // Generate
        $str = '';
        $output_count = strlen($output);
        for ($i = 0; $length > $i; $i++) {
            $str .= $output{mt_rand(0, $output_count - 1)};
        }

        return $str;
    }


    public static function strtotitle($title)
// Converts $title to Title Case, and returns the result.
    {
// Our array of 'small words' which shouldn't be capitalised if
// they aren't the first word. Add your own words to taste.
        $smallwordsarray = array(
            'of', 'a', 'the', 'and', 'an', 'or', 'nor', 'but', 'is', 'if', 'then', 'else', 'when',
            'at', 'from', 'by', 'on', 'off', 'for', 'in', 'out', 'over', 'to', 'into', 'with'
        );

// Split the string into separate words
        $words = explode(' ', $title);

        foreach ($words as $key => $word) {
// If this word is the first, or it's not one of our small words, capitalise it
// with ucwords().
            if ($key == 0 or !in_array($word, $smallwordsarray))
                $words[$key] = ucwords($word);
        }

// Join the words back into a string
        $newtitle = implode(' ', $words);

        return $newtitle;
    }

//remove underscors from a string
    public static function remove_underscore($string)
    {
        return str_replace('_', ' ', $string);
    }

//remove dashes between words
    public static function remove_dashes($string)
    {
        return str_replace('-', ' ', $string);

    }

//generate seo friendly funtions
    public static function seo_url($string)
    {
        //Lower case everything
        $string = strtolower($string);
        //Make alphanumeric (removes all other characters)
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //Clean up multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);
        //Convert whitespaces and underscore to dash
        $string = preg_replace("/[\s_]/", "-", $string);
        return strtolower($string);
    }


    # get youtube thumbnail
    public static function youtube_image($id)
    {
        //GET THE URL
        $url = $id;

        $queryString = parse_url($url, PHP_URL_QUERY);

        parse_str($queryString, $params);

        $v = $params['v'];
        //DISPLAY THE IMAGE
        if (strlen($v) > 0) {
            $url='http://i3.ytimg.com/vi/'.$v.'/default.jpg';
        }else{
            $url=null;
        }

        return $url;
    }


}
