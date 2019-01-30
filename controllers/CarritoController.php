<?php

require_once 'models/Producto.php';

class CarritoController 
{
    public function index()
    {
        $carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : array();

        require_once 'views/carrito/index.php';
    }

    public function add()
    {
        if(isset($_GET['id']))
        {
            $producto_id = $_GET['id'];
        }else{
            header("Location: ". base_url);
        }

        if (isset($_SESSION['carrito'])) 
        {
            $counter = 0;
            foreach($_SESSION['carrito'] as $indice=>$elemento)
            {
                if ($elemento['id_producto']==$producto_id) {
                    $_SESSION['carrito'][$indice]['unidades']++;
                    $counter++;
                }
            }
        }
       
        if (!isset($counter) || $counter==0) 
        {
            //Conseguir Producto
            $prod = new Producto();
            $prod->setId($producto_id);
            $producto = $prod->getOne();

            //Añadir al carrito
            if (is_object($producto)) {
                $_SESSION['carrito'][] = array(
                    "id_producto" => $producto->id,
                    "precio" => $producto->precio,
                    "unidades" => 1,
                    "producto" => $producto
                );
            }
        }

        header("Location: ".base_url."carrito/index");
    }

    public function delete()
    {
        if(isset($_GET['index']))
        {
            $index = $_GET['index'];
            unset($_SESSION['carrito'][$index]);
            header("Location: ".base_url."carrito/index");
        }
    }

    public function delete_all()
    {
        unset($_SESSION['carrito']);
        header("Location: ".base_url."carrito/index");
    }
}