<?php
/**
 * Clase para manejar variables de cookies.
 */
class Cookie
{    
    // -------------------------------------------------------------------------
    // Funciones generales
    // -------------------------------------------------------------------------
    
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
    
    // -------------------------------------------------------------------------
    // Funciones de la cookie page_rows
    // -------------------------------------------------------------------------    
    
    /**
     * Obtener o cambiar el valor actual de una cookie page_rows.
     * @param string $mod_id Id del módulo donde se hace el cambio
     * @param int $new_value Nuevo valor
     * @return int
     */
    public static function pageRows($mod_id, $new_value = 0)
    {
        $key = 'page_rows_' . $mod_id;
        
        if ($new_value > 0) {
            
            if (!self::pageRowsIsValid($new_value)) {
                $new_value = self::pageRowsDefaultValue();
            }
            
            $expiration =  time () + (60 * 60 * 24 * 365) * 10; // expiración dentro de 10 años
            self::set($key, $new_value, $expiration, '', PW_Request::domain(false));
            
        }
        
        return self::get($key);
    }
    
    /**
     * Determinar si existe la cookie page_rows de un módulo determinado.
     * @param string $mod_id Id del módulo
     * @return bool
     */
    public static function hasPageRows($mod_id)
    {        
        $key = 'page_rows_' . $mod_id;
        
        return self::has($key);
    }
    
    /**
     * Valores que se consideran válidos para la cookie page_rows.
     * @return array
     */
    public static function pageRowsValues()
    {
        return array(10, 20, 30, 40, 50);
    }

    /**
     * Valor por defecto usado en la cookie page_rows. 
     * @return int
     */
    public static function pageRowsDefaultValue()
    {
        return 20;
    }
    
    /**
     * Comprobar que $value esté dentro de los valores considerados válidos.
     * @param int $value
     * @return bool
     */
    public static function pageRowsIsValid($value)
    {
        $values = self::pageRowsValues();
        return in_array($value, $values);
    }
}
