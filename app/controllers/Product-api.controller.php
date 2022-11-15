<?php
require_once './app/models/Product.model.php';
require_once './app/views/api.view.php';

class ProducApiController {
    private $model;
    private $view;

    private $data;

    public function __construct() {
        $this->model = new ProducModel();
        $this->view = new ApiView();
        
        // lee el body del request
        $this->data = file_get_contents("php://input");
    }

    private function getData() {
        return json_decode($this->data);
    }

    public function getProducAll($params = null) {
            //Obtengo todos los productos con los parametros de ordenado, paginado y filtrado.

        // Parámetros de ordenado
        $orderBy = $_GET['orderBy'] ?? "nombre";
        $orderMode = $_GET['orderMode'] ?? "asc";
        
        // Parámetros de paginado, con valores por defecto
        $page = (int)($_GET['page'] ?? 1);
        $limit = (int)($_GET['limit'] ?? 50); 

        // Parámetros de filtrado
        $filterBy = $_GET['filterBy'] ?? null;
        $equalTo = $_GET['equalTo'] ?? null;
        
        //Obtiene los nombres de las columnas de la tabla productos y los almacena en el arreglo $columns.
        $columns = $this->getHeaderColumns();

        // Verifica si los parámetros de ordenado son válidos
        if (($orderBy == 'nombre' || in_array(strtolower($orderBy), $columns)) && (strtolower($orderMode == "asc") || strtolower($orderMode == "desc"))){

            if ($orderBy == 'nombre') {
                $order = 'categorias.nombre';
            }
            else {
                $order = 'productos.'.$orderBy;
            }
            // Verifica si los parámetros de paginado son válidos
            if((is_numeric($page) && $page>0) && (is_numeric($limit) && $limit>0)){
                $startAt = ($page*$limit)-$limit;
                // Verifica si existen los parámetros de filtrado
                if ($filterBy!=null && $equalTo!=null){

                    if ($filterBy == 'nombre' || in_array(strtolower($filterBy), $columns)){
                        //Asigna un valor $filter para pasar al modelo en funcion del campo por el que se quiere ordenar
                        if ($filterBy == 'nombre') {
                            $filter = 'categorias.nombre';
                        }
                        else {
                            $filter = $filterBy; 
                        }                     
                        //Obtiene todos los productos del modelo y pasa los parametros de ordenamiento, paginado y filtrado.
                        $response = $this->model->getAllWithFilter($order, $orderMode, $limit, $startAt, $filter, $equalTo);

                        if(isset($response)){

                            if (empty($response)) {
                                $this->view->response("La consulta realizada no arrojó resultados", 204);
                            }
                            else {
                                $this->view->response($response, 200);
                            }
                        }
                        else {
                            $response = $this->view->response("No se pudo realizar la consulta especificada.", 500);
                        }                            
                    }
                    else {
                        $response = $this->view->response("Parámetro de filtrado no válido.", 400);
                    }                        
                }
                else {
                   //Obtiene todos los productos del modelo y pasa los parametros de ordenamiento y paginado.
                   $response = $this->model->getAllProduc($order, $orderMode, $limit, $startAt);
                    $this->view->response($response,200);
                }   
            }  
            else {
                $response = $this->view->response("Parámetro de paginado no válido.", 400);       
            }
        }
        else {
            $response = $this->view->response("Parámetro de ordenamiento no válido", 400);
        }
    
    }

     function getHeaderColumns($params = null) {

        $columns = [];
        $result = $this->model->getColumns();
        foreach ($result as $column) {
            array_push($columns, $column->Field);
        }
        return $columns;
    }

    public function getProduc($params = null) {
        $id = $params[':ID'];
        $produc = $this->model->getProduct($id);

        if ($produc)
            $this->view->response($produc);
        else 
            $this->view->response("El producto con el id=$id no existe", 404);
    }

    public function deleteProduc($params = null) {
        $id = $params[':ID'];

        $produc = $this->model->getProduct($id);
        if ($produc) {
            $this->model->deleteProducById($id);
            $this->view->response($produc);
        } else 
            $this->view->response("La tarea con el id=$id no existe", 404);
    }

    public function insertProduc($params = null) {
        $produc = $this->getData();

        if (empty($produc->titulo) || empty($produc->descripcion) || empty($produc->precio) || empty($produc->id_categorias)) {
            $this->view->response("Complete los datos", 400);
        } else {
            $id = $this->model->insertProduc($produc->titulo, $produc->descripcion, $produc->precio, $produc->id_categorias);
            $produc = $this->model->getProduct($id);
            $this->view->response($produc, 201);
        }    
    }
}