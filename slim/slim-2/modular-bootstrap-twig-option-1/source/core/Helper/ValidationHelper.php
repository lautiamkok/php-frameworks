<?php
/*
 * Validation helper.
*/
namespace Barium\Helper;

trait ValidationHelper
{
    /*
     * filter an email input
     * @param string $email
     * @return boolean false if invalid
     * @return string $email if valid
     * @usage 1: $email = validate_email($email);
     *
     */
    public function validateEmail($email)
    {
        // Check if the version of php is at least 5.2.0.
        if(version_compare(PHP_VERSION, '5.2.0') >= 0) 
        {
            // filters the variable with FILTER_VALIDATE_EMAIL
            return filter_var($email, FILTER_VALIDATE_EMAIL);
            
        }

        // Fall back to preg_match and regex.
        else
        {
            // set the regex for checking the email
            $regex = '/^[^@]+@[^\s\r\n\'";, @%]+$/';

            // reject the email address if it doesn't match
            if (!preg_match($regex, $email)) return false;
        }
        return $email;
    }

    /*
     * filter an url input
     * @param string $url
     * @return boolean false if invalid
     * @usage 1: $url = validate_email($url);
     */
    public function validateUrl($url)
    {
        // check if the version of php is at least 5.2.0.
        if(version_compare(PHP_VERSION, '5.2.0') >= 0) 
        {
            $url = filter_var($url, FILTER_VALIDATE_URL);
        }
        // Else a fallback.
        else
        {
            // set the regex for checking.
            $regex = '/^http:\/\/.*/';

            // reject the url address if it doesn't match
            if (!preg_match($regex, $url)) return false;
        }

        // Make sure it is not false.
        if($url)
        {
            // Make sure it is only one http:// in the string.
            if (strrpos($url, "http://") > 0) 
            {
                return false;
            }
            else 
            {
                return true;
            }
        }
        return false;
    }


    /*
     * search for alphabet & numbers only.
     * @param string $string
     * @return boolean false or true
     *
     */
    public function alphaNumber($string, $options = [])
    {
        // Set default.
        $defaults = array(
            "allow_pattern"	=>	null, 
            "allow_uppercase"	=>	false
     );

        // Compare and convert.
        $settings = $this->arrayToObject($this->arrayMergeValues($defaults, $options));

        if($settings->allow_pattern)
        {
            $items = explode(',', $settings->allow_pattern);
            $items = implode('\\', $items);
            //var_dump($items);

            if($settings->allow_uppercase === true)
            {
                if(!preg_match('/^[a-zA-Z0-9\\'.$items.']+$/', $string)) return false;
            }
            else
            {
                if(!preg_match('/^[a-z0-9\\'.$items.']+$/', $string)) return false;
            }
        }
        else
        {
            if($settings->allow_uppercase === true)
            {
                if(!preg_match('/^[a-zA-Z0-9]+$/', $string)) return false;
            }
            else
            {
                if(!preg_match('/^[a-z0-9]+$/', $string)) return false;
            }
        }

        return true;
    }

    /*
     * search for multiple paterns.
     * @param string $string
     * @param string $options, such as, "target_pattern"=> "s, -, _".
     * @return boolean false or true
     *
     */
    public function multiplePatterns($string, $options = [])
    {
        // Set default.
        $defaults = array(
            "target_pattern" =>	null
     );

        // Compare and convert.
        $settings = $this->arrayToObject($this->arrayMergeValues($defaults, $options));

        if($settings->target_pattern)
        {
            $items = explode(',', $settings->target_pattern);
            $items = implode('', $items);

            /*
            foreach($items as $item)
            {
                    if(preg_match("/"."\\".$item."\\".$item."+/", $string)) return true;
            }
            */

            // @reference: http://stackoverflow.com/questions/13182683/check-for-multiple-and-combination-patterns-with-php-preg-match
            if(preg_match('/[\\'.$items.'][\\'.$items.']+/', $string)) return true; //'/[\s-_][\s-_]+/'
            //if(preg_match('/\s\s+/', $string)) return true; 
        }
        else
        {
            return false;
        }

        return false;
    }

    /*
     * search for paterns at the beginning and the end of a string.
     * @param string $string
     * @param string $options, such as, "target_pattern"=> "s, -, _".
     * @return boolean false or true
     *
     */
    public function has_ends($string, $options = [])
    {
        // Set default.
        $defaults = array(
            "target_pattern"	=>	null
     );

        // Compare and convert.
        $settings = $this->arrayToObject($this->arrayMergeValues($defaults, $options));

        if($settings->target_pattern)
        {
            $items = explode(',', $settings->target_pattern);
            $items = implode('', $items);

            if(preg_match('/([\\'.$items.']$)|(^[\\'.$items.'])/', $string)) return true; //'/([\s-_]$)|(^[\s-_])/'
            //if(preg_match('/([\s-_]$)|(^[\s-_])/', $code))
        }
        else
        {
            return false;
        }
        return false;
    }

    /*
     * search for multiple spaces.
     * @param string $string
     * @return boolean false or true
     *
     */
    public function has_multiple_spaces($string)
    {
        if(preg_match('/\s\s+/', $string)) return true;

        return false;
    }
    
    /*
     * tidy html/ text.
     * @param string $string
     * @param string $type
     * @return boolean false or true
     *
     */
    public function tidyString($content, $type = 'newsletter')
    {
        // Instantiate an object from constant class
        $constant = new Constant($this->PdoAdapter);

        // Instanticiate the tidy object.
        $tidy = new \base\helper\Tidy($this->PdoAdapter);

        $tidy_options = $constant->getRow('tidy_options')->value;

        // Turn the string into json object data.
        $tidy_options_decoded = json_decode($constant->getRow('tidy_options')->value);

        // Check if the input has HTML tags. If it has, tidy up the HTML.
        if ($content !== strip_tags($content))
        {
            // Check if it is a type of newsletter and it is not set to escape tidy html, otherwise, tidy it.
            if($type !== 'newsletter' && (isset($tidy_options_decoded->allow) && $tidy_options_decoded->allow->all !== true)) return $tidy->html($content, $tidy_options);
            else return $content;
        }
        else
        {
            // Tidy text.
            $content = $tidy->text($content);
        }
        return $content;
    }
}
