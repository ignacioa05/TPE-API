# API REST para mostrar productos de indumentaria deportiva
Una API REST para manejar un CRUD de productos

## Importar la base de datos
- importar desde PHPMyAdmin (o cualquiera) database/db_indumentariadepor.php


## Pueba con postman


Get Productos=
http://localhost/web/API_CaliDeportes/api/produc

Con esto me voy a poder traer todos los productos que contenga mi base de datos.

Puedo obtenerlos de forma aletoria o de acuerdo a los parametros que yo quiera pasarle.
Ya sea Ordenados de acuerdo a un campo especifico (OrderBy) y tambien poder ordenarlos de forma 
ascendente o descendente (orderMode).

Puedo ademas poder filtrar y realizar una busqueda por campo especifico (filterBy, equalTo)

Tambien podemos realizar paginacion (page) de los productos obtenido, haciendo una limitacion de los productos
a mostrar (limit)

Podremos hacer una consulta por cada uno de los nombrados recientemente o podemos realizar las combinaciones posibles.

Mensajes y Codigos de respuesta: 200: Ok, JSON con los datos de la request 
                                 204: "La consulta realizada no arrojó resultados." 
                                 400: "Parámetro de ordenado/ paginado/ filtrado no válido." 
                                 500: "No se pudo realizar la consulta especificada."

Get Producto Determinado=
http://localhost/web/API_CaliDeportes/api/produc/ID

Con este endpoint podremos obtener un producto determinado pasandole su ID correspondiente.

Mensajes y Codigos de respuesta: 200: JSON con los datos de la request 
                                 404: "El producto con el id=$id no existe".

Post Insertar un Producto=
http://localhost/web/API_CaliDeportes/api/produc

Voy a poder realizar la insercion de un producto a mi base de datos. 
Esto lo realizo por medio de un metodo POST, en la cual voy agregar en la seccion "body" -> "raw" el JSON
del producto que quiero insertar. 

{
        "titulo": "Short de Futbol",
        "descripcion": "Equipo Boca",
        "precio": "1000",
        "id_categorias": "5",
        "nombre": "Shorts"
    }

Debo de tener en cuenta de no poner el ID del producto, ya que el mismo es autoincremetal y se genera automatico.

Mensajes y Codigos de respuesta: 201: JSON completo 
                                 400: "Complete los datos"

Delete Eliminar Producto=
http://localhost/web/API_CaliDeportes/api/produc/ID

Podremos realizar la eliminacion de alguno de los productos, pasandole el ID correspondiente. 



