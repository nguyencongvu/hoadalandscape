<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\PhpRenderer;
use Slim\Views\PhpRenderer\RuntimeException;
use Slim\Views\PhpRenderer\InvalidArgumentException;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Http\UploadedFile;


include "./config/config.php"; 
include "./func.php"; 


// ---------------------------------------------  
//  SET APP run on subfolder  
//---------------------------------------------- 
$SUBFOLDER = get_base(); // in func.php 
$app = AppFactory::create();
if ($SUB !='')
    $app->setBasePath($SUB); // run from a subfolder
// bo qua setBasePath de chay tren demo.webup.top /root



// ---------------------------------------------  
// CORS enabled 
//---------------------------------------------- 
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});
$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});





// --------------------------------------------------------
//   ROUTES 
// --------------------------------------------------------
$app->group('', function (RouteCollectorProxy $group) {
    
    
    //--- sitemap ---//
    $group->get('/sitemap[{path:.*}]', function (Request $request, Response $response, $args) {
        $data = show_sitemap(); 
        $renderer = new PhpRenderer(__DIR__."/templates/"); // end slash require 
        $template = "sitemap.php";
        return $renderer->render($response, $template, $data);
    });


    
    //--- home/home-1 ---//    
    $group->get('/', function (Request $request, Response $response, $args) {
        // global $lang;
        $params = $request->getQueryParams();
        // $lang = $params['lang'] ? $params['lang'] : null ;  // group args 
        $renderer = new PhpRenderer(__DIR__."/templates/"); // end slash require 

        $lang = $_SESSION["lang"];
        $data = show_home($lang);  

        $template = "home/home-1.php";
        $renderer->setLayout("layout.php");

        return $renderer->render($response, $template, $data); 
    });



    //-- blog, product, shop, contact, thank... ---//
    $group->get('/{name}', function (Request $request, Response $response, $args) {
        $params = $request->getQueryParams();
        // $lang = $params['lang'] ? $params['lang'] : null ;  // group args 
        $name = $args['name'] ? $args['name'] : '' ;
        $renderer = new PhpRenderer(__DIR__."/templates/"); // end slash require 

        $lang = $_SESSION["lang"];
        // default 
        $data = array(); 
        $template = "home-1.php"; 


        // tach rieng landing page 
        if (in_array($name, array('page','landing-page'))){ 
            $data = show_landing_page($lang);  
            $template = "page-1.php"; // landing page 
            $renderer->setLayout("layout.php");
        }
        if (in_array($name, array('blog','bai-viet'))){ 
            $data = show_blog($lang); // show_blog   
            $template = "blog-1.php"; // blog 1 ok 
            $renderer->setLayout("layout.php");
        }
        if (in_array($name, array('shop','cua-hang'))){ 
            $data = show_shop($lang);  
            $template = "shop-1.php"; // new shop 
            $renderer->setLayout("layout.php");
        }
        if (in_array($name, array('contact','lien-he'))){ 
            $data = show_contact($lang);  
            $template = "contact.php";
            $renderer->setLayout("layout.php");
        }
        if (in_array($name, array('thank','thank-you','cam-on'))){ 
            $data = show_thank($lang);  
            $template = "thank.php";
            $renderer->setLayout("layout.php");
        }
        // echo $template;
        return $renderer->render($response, $template, $data); 
    }); 





    // --- page/abc, post/=abc  -----------
    $group->get('/{name}/{slug}', function (Request $request, Response $response, $args) {
        global $lang;
        // $lang = $args['lang'] ? $args['lang'] : $lang ;  // group args 
        $params = $request->getQueryParams();
        // $lang = $params['lang'] ? $params['lang'] : null ;  // group args 

        $object_type = $args["name"]; // post, product 
        $slug = $args["slug"]; // category="ABC"

        $lang = $_SESSION["lang"];
        $data = show_one($object_type, $slug, $lang);
        
        $renderer = new PhpRenderer(__DIR__."/templates/"); // end slash require 
        $renderer->setLayout("layout.php");
        $template = "view.php";

        if ($object_type=='product')
            $template = "view-product.php";
        return $renderer->render($response, $template, $data);
    });



    
    
    
    // --- home/category  -----------
    $group->get('/{name}/category[/{slug}]', function (Request $request, Response $response, $args) {
        $params = $request->getQueryParams();
        // $lang = $params['lang'] ? $params['lang'] : null ;  // group args 

        $object_type = $args["name"]; // post, product 
        $slug = $args["slug"]; // category="ABC"

        $lang = $_SESSION["lang"];
        $data = show_category($object_type, $slug, $lang);
        
        $renderer = new PhpRenderer(__DIR__."/templates/"); // end slash require 
        $renderer->setLayout("layout.php");
        $template = "home/category.php";
        return $renderer->render($response, $template, $data);
    });



    

    // --- home/view/post/abc, view-product  show_one -----------
    $group->get('/view/{name}/{slug}', function (Request $request, Response $response, $args) {
        $params = $request->getQueryParams();
        // $lang = $params['lang'] ? $params['lang'] : null ;  // group args 

        $object_type = $args["name"]; // page or page_en (to get_en) 
        $slug = $args["slug"];

        $lang = $_SESSION["lang"];
        $data = show_one($object_type, $slug, $lang);

        $renderer = new PhpRenderer(__DIR__."/templates/"); // end slash require 
        $renderer->setLayout("layout.php");
        $template = "home/view.php";
        if ($object_type=='product')
            $template = "home/view-product.php";
        
        return $renderer->render($response, $template, $data);
    });

});

//-------------------------------------------------------------------------------------
// ADMIN upload 
//-------------------------------------------------------------------------------------
$app->group('/v1/admin', function (RouteCollectorProxy $group) {

    $group->get('/analytics', function (Request $request, Response $response, $args) {
        global $lang;
        $lang = $args['lang'] ? $args['lang'] : $lang ;  // group args 
        $data = show_analytic();  
        $renderer = new PhpRenderer(__DIR__."/templates/admin/"); // end slash require 
        // $renderer->setLayout("layout.php");
        $template = "analytic.php";
        return $renderer->render($response, $template, $data); 
    });

    // --- admin ---------------------------
    $group->get('/upload', function (Request $request, Response $response, $args) {
        $data = show_upload(); 

        $payload = json_encode($data);
        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');    

    });

    // su dung cho Control Q-uploader 
    $group->post('/uploadfiles', function (Request $request, Response $response, $args) {
        $folder = __DIR__."/images/";
        $files = $_FILES; //$_FILES["uploadfile"]["name"] and $_FILES["uploadfile"]["tmp_name"] default 
        $module = $_POST["module"] ?  $_POST["module"] : "";
        // var_dump($files);
        // die() ;

        $data = do_upload($folder, $module, $files); 

        $payload = json_encode($data);
        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');    
    });

    // Xoa File bang POST 
    $group->post('/upload', function (Request $request, Response $response, $args) {
        $folder = __DIR__."/images/";
        $input = json_decode(file_get_contents('php://input'),true); // do not use $requet
        $data = delete_upload($input); 
        $payload = json_encode($data);
        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json'); 
    });



});





//-------------------------------------------------------------------------------------
/**
 * CORS Catch-all route to serve a 404 Not Found page if none of the routes match
 * NOTE: make sure this route is defined last
 */
$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
    throw new HttpNotFoundException($request);
});

$app->run();