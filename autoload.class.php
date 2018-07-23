<?php
class Loader
{
    /* 路径映射 */
    public static $vendorMap = array(
        'app' => __DIR__ . DIRECTORY_SEPARATOR,
    );

    /**
     * 自动加载器
     */
    public static function autoload($class)
    {
        $file = self::findFile($class);
        echo $file;
        if (file_exists($file)) {
            self::includeFile($file);
        }
    }

    /**
     * 解析文件路径
     */
    private static function findFile($class)
    {
       
        $vendor = substr($class, 0, strpos($class, '\\')); // 顶级命名空间
        $vendorDir = self::$vendorMap[$vendor]; // 文件基目录/var/www/httpdocs/dede/dede/weixin/
        $filePath = substr($class, strlen($vendor)) . '.class.php'; // 文件相对路径
        //echo $filePath;
        $filePath = $vendorDir . $filePath;
        return str_replace('/\\', '/', $filePath);
        //return strtr($vendorDir . $filePath, '\\', DIRECTORY_SEPARATOR); // 文件标准路把路径中的\替换成/
    }

    /**
     * 引入文件
     */
    private static function includeFile($file)
    {
        if (is_file($file)) {
            include $file;
        }
    }
}
