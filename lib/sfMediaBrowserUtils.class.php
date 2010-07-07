<?php
/*
 * This file is part of the sfMediaBrowser package.
 *
 * (c) 2009 Vincent Agnano <vincent.agnano@particul.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package sfMediaBrowser
 * @author Vincent Agnano <vincent.agnano@particul.es>
 *
 */
class sfMediaBrowserUtils
{
  protected $type_extension = array(
    'document' => array('doc', 'xls', ''),
  );

  public static $icons_path;

  /**
   * Returns the string filetype for a given file extension.
   *
   * @static
   * @param  string $extension The extension of a filename (without the .)
   * @return string
   */
  static public function getTypeFromExtension($extension)
  {
    $extension = self::cleanString($extension);
    $types = self::getFileTypes();
    foreach($types as $type => $data)
    {
      if(in_array($extension, $data['extensions']))
      {
        return $type;
      }
    }
    return 'file';
  }
  
  /**
   * Returns the string filename (e.g. file.png) to be used as the icon
   * that represents the given file type.
   *
   * @static
   * @param  string $type The string file type
   * @return string
   */
  static public function getIconFromType($type)
  {
    $types = self::getFileTypes();
    $dir = self::getIconsDir();
    if(array_key_exists($type, $types))
    {
      $icon = array_key_exists('icon', $types[$type])
            ? $types[$type]['icon']
            : $type
            ;
      return $dir.'/'.$icon.'.png';
    }

    return $dir.'/file.png';
  }

  /**
   * Returns the name of an asset with the extension stripped off
   *
   * @static
   * @param  string $file The full filename (e.g. my_photo.png)
   * @return string
   */
  static public function getNameFromFile($file)
  {
    $dot_position = strrpos($file, '.');
    return $dot_position ? substr($file, 0, $dot_position) : $file;
  }
  
  /**
   * Returns the file extension (without the .) for a file.
   *
   * @static
   * @param  string $file The full filename (e.g. my_photo.png)
   * @return string
   */
  static public function getExtensionFromFile($file)
  {
    return strtolower(substr(strrchr($file, '.'), 1));
  }

  /**
   * Returns the icon to use (e.g. file.png) for a given file extension
   *
   * @static
   * @param  string $extension The file extension (without the .)
   * @return string
   */
  static public function getIconFromExtension($extension)
  {
    $dir = '/sfMediaBrowserPlugin/images/icons';
    $path = self::getIconsPath();
    if(file_exists($path.'/'.$extension.'.png'))
    {
      return $dir.'/'.$extension.'.png';
    }

    return self::getIconFromType(self::getTypeFromExtension($extension));
  }

  /**
   * Returns the array of file_types config
   *
   * @static
   * @return array
   */
  static public function getFileTypes()
  {
    return sfConfig::get('app_sf_media_browser_file_types', array());
  }


  /**
   * Clean a string : lower cased and trimmed
   * 
   * @param string string to clean
   * @return string cleaned string
   */
  static public function cleanString($value)
  {
    return strtolower(trim($value));
  }


  static public function getIconsPath()
  {
    if(!self::$icons_path)
    {
      self::$icons_path = sfConfig::get('sf_web_dir').self::getIconsDir();
    }
    return self::$icons_path;
  }

  static public function getIconsDir()
  {
    return '/sfMediaBrowserPlugin/images/icons';
  }
  
  
  static public function deleteRecursive($path)
  {
    $files = sfFinder::type('file')->in($path);
    foreach($files as $file)
    {
      unlink($file);
    }
    $dirs = array_reverse(sfFinder::type('dir')->in($path));
    foreach($dirs as $dir)
    {
      rmdir($dir);
    }

    return @rmdir($path);
  }
  
  
  /**
   * Loads js and css files to the response. This is an abstraction layer
   * for no dependency of sfAssetsManagerPlugin
   * 
   * @see sfAssetsManagerPlugin
   * @param string $package package name to load
   * @param sfWebResponse optional. Context Response by default
   */
  static public function loadAssets($package, sfWebResponse $response = null)
  {
    $response = $response ? $response : sfContext::getInstance()->getResponse();
    
    // sfAssetsManager
    if(class_exists('sfAssetsManager'))
    {
      $manager = sfAssetsManager::getInstance();
      $manager->load(sprintf('sfMediaBrowser.%s', $package));
    }
    // app.yml configuration
    else
    {
      $config = sfConfig::get(sprintf('app_sf_media_browser_assets_%s', $package));
      if(isset($config['js']) && !empty($config['js']))
      {
        foreach((array) $config['js'] as $js)
        {
          $response->addJavascript($js);
        }
      }
      if(isset($config['css']) && !empty($config['css']))
      {
        foreach((array) $config['css'] as $css)
        {
          $response->addStylesheet($css);
        }
      }
    }
  }
}