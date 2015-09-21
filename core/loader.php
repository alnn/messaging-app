<?php

/**
 * Split class name into parts and return them
 * 
 * @param string $strClassName
 * @return array
 * @throws Exception
 */
function getClassParts($strClassName)
{
    
    $arrParts = explode('_', $strClassName);
    if (count($arrParts) == 0) {
        throw new Exception('Empty Class Name');
    }
    
    return $arrParts;
}

/**
 * Autoloader for classes
 * @param string $strClassName
 * @return boolean
 * @throws Exception
 */
function autoloader($strClassName) 
{
    
    if (preg_match('@[\/\.]@', $strClassName)) { 
        throw new Exception('Class Name ' . $strClassName . ' could not be allowed');
    }
    
    $arrPart = getClassParts($strClassName);
    
    $strDir  = __DIR__;
    
    if ($arrPart[0] == 'App') {
        $strDir .= '/';    
    } else {
        $strDir .= '/../classes/';
    }
    
    $strPath = $strDir . implode('/', getClassParts($strClassName)) . '.php';
    
    if (file_exists($strPath))  {
        require $strPath;
        return true;
    }
    
    return false;
}

spl_autoload_register('autoloader');
