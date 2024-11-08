<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        require 'conexion.php';
    
        $usuario = htmlspecialchars($_POST['usuario']);
        $contraseña = htmlspecialchars($_POST['contraseña']);
    
        try {
            // Preparar y ejecutar la consulta
            $sql = $conn->prepare('SELECT * FROM login WHERE usuario_login = :usuario');
            $sql->bindParam(':usuario', $usuario);
            $sql->execute();
            $resultado = $sql->fetch(PDO::FETCH_ASSOC);
    
            if ($resultado) {
                $hash = $resultado['password_login'];
    
                // Verificar la contraseña ingresada con la encriptada
                if (password_verify($contraseña, $hash)) {
                    session_start();
                    $_SESSION["username"] = $usuario;
                    $_SESSION["rol"] = $resultado['rol_login']; // Guardar el rol del usuario en la sesión
    
                    // Establecer cookie de sesión
                    setcookie("activo", 1, time() + 3600);

                    // Redirigir al panel principal
                    header("Location: paneles.php", true, 301);


                    exit(); // Después de redirigir
                } else {
                    // Contraseña incorrecta
                    //http_response_code(401);
                    header('Location: proyecto_final.php?err=1');
                    exit();
                }
            }else {
                // Usuario no encontrado
                http_response_code(404);
                header('Location: proyecto_final.php?err=2');
                exit();
            }
    
        } catch (PDOException $e) {
            // Manejo de errores
            echo "Error: " . $e->getMessage();
        }
    }
    

?>