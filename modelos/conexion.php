<?php
class Conexion
{
    static public function conectar()
    {
        #PDO("nombre del servidor;Nombre de la base de datos","Nombre de usuario","Contraseña");
        $link = new PDO(
            "mysql:host=localhost;dbname=cursos_upa",
            "Cursos-upa",
            "123456"
        );
        $link->exec("set names utf8");
        return $link;
    }
}
