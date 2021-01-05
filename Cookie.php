<?php
/**
 * Clase para manejar variables de cookies.
 */
class Cookie
{    
    /**
     * Obtener una variable de cookie.
     * @param string $key Nombre de la variable.
     * @return mixed
     */
    public static function get($key)
    {        
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
    }
    
    /**
     * Asignar una variable de cookie.
     * Los parámetros son los mismos de la función setcookie():
     * https://www.php.net/manual/en/function.setcookie.php
     * @param string $key
     * @param string $value
     * @param int $expires
     * @param string $path
     * @param string $domain
     * @param bool $secure
     * @param bool $httponly
     */
    public static function set($key, $value, $expires = 0, $path = '', $domain = '', $secure = false, $httponly = false)
    {        
        setcookie($key, $value, $expires, $path, $domain, $secure, $httponly);
    }
    
    /**
     * Eliminar una cookie. Si la cookie fue creada indicando un valor $path
     * entonces también hay que indicar ese valor para borrarla.
     * @param string $key Nombre de la variable.
     */
    public static function destroy($key, $path = '')
    {
        unset($_COOKIE[$key]);
        setcookie($key, '', 1, $path);       
    }
    
    /**
     * Verificar si existe una variable de cookie.
     * @param string $key Nombre de la variable.
     * @return boolean
     */
    public static function has($key)
    {
        return !is_null(self::get($key));
    }
    
    public static function debug()
    {
        print '<pre>';
        var_dump($_COOKIE);
        print '</pre>';
    }
}
