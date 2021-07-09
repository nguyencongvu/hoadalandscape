<?php 
use GuzzleHttp\Client; // call curl - put here 
// https://docs.guzzlephp.org/en/stable/quickstart.html


// ----- home --- 
function show_home($lang=null){
    // global $DEFAULT_LANG;
    global $api; 
    global $customer; 

    $endpoint = $api."/v1/api/{$customer}/show/home" ; // --> /home-en (slug)
    $endpoint .= "?ver=1"; 
    $endpoint .= "&lang={$lang}";  // luc nao cung co lang 

    // var_dump($endpoint);
    // die(); 

    $response = curl_get($endpoint);

    $data = array(
        "lang"=>$lang,
        "site"=>$response->site[0],
        "layout"=>$response->layout,
        "category"=>$response->category,
        "pages"=>$response->pages,
        "posts"=>$response->posts,
        "products"=>$response->products,
    );
    
    // var_dump($data);
    return $data; 
}

// ----- one page, post, product   --- 
function show_one($object,$slug, $lang=null){

    global $api; 
    global $customer; 

    $endpoint = $api."/v1/api/{$customer}/site/home-{$lang}" ; // --> /home_en (slug)
    $endpoint .= "?ver=1"; 
    // $endpoint .= "&lang={$lang}";  // luc nao cung co lang 
    $response = curl_get($endpoint); 
    $site = $response->objects[0];

    $endpoint = $api."/v1/api/{$customer}/{$object}/{$slug}" ; // --> /home_en (slug)
    $response = curl_get($endpoint); 
    $one = $response->objects[0];

    $endpoint = $api."/v1/api/{$customer}/category" ; 
    $response = curl_get($endpoint); 
    $category = $response->objects;

    $endpoint = $api."/v1/api/{$customer}/post" ; // --> /home_en (slug)
    $endpoint .= "?filters=category::has(chinh-sach)";
    $response = curl_get($endpoint); 
    $policy = $response->objects;

    $site->site_title = $one->title;
    $site->site_description = strip_tags($one->summary);
    // $site->image = $one->images;

    $data = array(
        "lang"=>$lang,
        "site"=>$site,  // assigned
        "category"=>$category,
        "object"=>$one, // assigned 
        "object_type"=>$object,
        "policy"=>$policy,
    );    

    return $data; 
}

// /post/categpry/abc
function show_category($object_type, $slug, $lang=null){
    global $api; 
    global $customer; 


    $endpoint = $api."/v1/api/{$customer}/site/home-{$lang}" ; // --> /home_en (slug)
    $response = curl_get($endpoint); 
    $site = $response->objects[0];

    $endpoint = $api."/v1/api/{$customer}/category" ; 
    $response = curl_get($endpoint); 
    $category = $response->objects;


    $endpoint = $api."/v1/api/{$customer}/post" ; // --> /home_en (slug)
    $endpoint .= "?filters=category::has(chinh-sach)";
    $response = curl_get($endpoint); 
    $policy = $response->objects;

    $endpoint = $api."/v1/api/{$customer}/{$object_type}" ; 
    $endpoint .= "?ver=1.0";
    $endpoint .= "&lang={$lang}"; 
    $response = curl_get($endpoint);
    $objects = $response->objects; 


    $data = array(
        "lang"=>$lang,
        "site"=>$site, 
        "objects"=>$objects, 
        "object_type"=>$object_type,
        "category_slug"=>$slug, 
        "category"=>$category,
        "policy"=>$policy,
    );

    return $data; 
}


// policy chinh-sach tieng viet 
function show_policy() {
    global $api;
    global $customer; 

    $endpoint = $api."/v1/api/{$customer}/post" ; // --> /home_en (slug)
    // $endpoint .= $lang ? "?lang={$lang}" : "";
    $endpoint .= "?filters=category::has(chinh-sach)";
    $response = curl_get($endpoint); 
    $policy = $response->objects;

    // $data = array(
    //     "policy"=>$policy,
    // );

    return $policy; 
} 

// ----- shop  ---------
function show_shop($lang){
    global $api; 
    global $customer; 

    $lang = $_SESSION['lang']; // may be null need null 
    $endpoint = $api."/v1/api/{$customer}/show/shop" ; 
    $endpoint .= "?ver=1.0";
    $endpoint .= "&lang={$lang}"; 
    $response = curl_get($endpoint);


    $data = array(
        "lang"=>$lang,
        "site"=>$response->site[0], 
        "product"=>$response->product, // posts = products 
        "category"=>$response->category, 
        "post"=>$response->post, 
        "tax"=>$response->tax, 
    );

    // var_dump($data);
    return $data; 
}

// ----- landing page  --- 
function show_landing_page($lang){
    global $api; 
    global $customer; 

    $lang = $_SESSION['lang']; // may be null need null 
    $endpoint = $api."/v1/api/{$customer}/show/page" ; 
    
    $endpoint .= "?ver=1.0";
    $endpoint .= "&lang={$lang}"; 

    $response = curl_get($endpoint);


    $data = array(
        "lang"=>$lang,
        "site"=>$response->site[0],
        "pages"=>$response->pages,
        "products"=>$response->products,
        "posts"=>$response->posts,
    );
    return $data; 
}

// ----- blog --- 
function show_blog($lang){
    global $api; 
    global $customer; 

    $lang = $_SESSION['lang']; // may be null need null 

    $endpoint = $api."/v1/api/{$customer}/show/blog";
    $endpoint .= "?lang={$lang}"; 
    $response = curl_get($endpoint);

    $data = array(
        "lang"=>$lang,
        "site"=>$response->site[0], 
        "posts"=>$response->posts, 
        "category"=>$response->category, 
    );

    return $data; 
}

// ----- contact --- 
function show_contact($lang) {
    global $api; 
    global $customer; 

    $endpoint = $api."/v1/api/{$customer}/site/home-{$lang}"; // --> /home (slug)
    $response = curl_get($endpoint);
    // var_dump($response);

    $data = array(
        "lang"=>$lang,
        "site"=>$response->objects[0],
    );
    return $data; 

} 

// ----- thank --- 
function show_thank($lang) {
    global $api; 
    global $customer; 

    $endpoint = $api."/v1/api/{$customer}/site/home-{$lang}"; // --> /home (slug)
    $response = curl_get($endpoint);
    // var_dump($response);


    $data = array(
        "lang"=>$lang,
        "site"=>$response->objects[0],
    );
    return $data; 
} 

// ----- sitemap  --- 
function show_sitemap(){
    global $lang;
    global $api; 
    global $customer; 

    // $lang = $_SESSION['lang']; // may be null need null 
    // $lang = ($lang!='vi') ? $lang : null;

    $endpoint = $api."/v1/api/{$customer}/show/sitemap" ; 
    // $endpoint .= $lang ? "&lang={$lang}" : "sitemap"; 
    $response = curl_get($endpoint);

    $data = array(
        "pages"=>$response->pages, 
        "posts"=>$response->posts,
        "products"=>$response->products
    );      
    
    return $data; 
}








// ---------------------------------------------------
//  upload  
// ---------------------------------------------------
function show_upload($subfolder=null) {
    // list all image in folder
    $folder = "./images/"; // must have . 
    $folder .= $subfolder ? $subfolder."/" : "";
    
    $local = glob("" . $folder . "{*.jpg,*.jpeg,*.gif,*.png,*.webp,*.svg,*.pdf}", GLOB_BRACE);
    $IMAGES=[];
    $IMAGES = $local; // not map yet 
    return $IMAGES; 
} 

function do_upload($folder, $module, $FILES){
    $data = array();
    $MAX_SIZE = 2048; 
    // tam thoi cho upload 1 file 
    $filename = "";
    if ($FILES["uploadfile"]) { 

        $tempname = $FILES["uploadfile"]["tmp_name"]; // fixed name, no lowercase pls
        $filename = strtolower($FILES["uploadfile"]["name"]); 
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        $folder .= $filename; 
        if ($ext=="jpg" OR $ext=="jpeg" OR $ext=="gif" OR $ext=="png" OR $ext=="webp" OR $ext=="svg" OR $ext=="pdf") {

            $compress_ext = array('png','jpeg','jpg');
            $size = filesize($tempname);
            $do_compress = ($size/1024 > $MAX_SIZE) ? true: false;   // max size=300

            if(in_array($ext,$compress_ext) AND $do_compress){
                // Compress Image
                $rate = 68;
                compressImage($tempname,$folder,$rate);
            }
            else { // webp, pdf, gif...
                // Now let's move the uploaded image into the folder: images 
                if (move_uploaded_file($tempname, $folder)) { 
                    $msg = "Image uploaded successfully"; 
                } else{ 
                    $msg = "Failed to upload image"; 
                } 
            }
        } else {
            $msg = "File type not allowed"; 
        } 
    }
    $data = array(
        "files" => $FILES,
        "folder"=> $folder,
        "module" =>$module,
        "filename"=>$filename,
        "message"=>$msg
    );
    return $data; 
}

function delete_upload($input) {
    $filename = $input['filename'];
    $folder = "./images/".$filename; // must have . 
    unlink($folder);
    $data = array(
        "status"=> "ok",
        "message"=>"deleted",
        "file_deleted"=>$folder,
        "input"=>$input,
    ); 
    return $data; 
} 

// ---------------------------------------------------
// Compress image and move upload file 
// ---------------------------------------------------
function compressImage($source,$destination, $quality) {
    try { 
        $info = getimagesize($source);
  
        if ($info['mime'] == 'image/jpeg') 
          $image = imagecreatefromjpeg($source);
      
        elseif ($info['mime'] == 'image/gif') 
          $image = imagecreatefromgif($source);
      
        elseif ($info['mime'] == 'image/png') 
          $image = imagecreatefrompng($source);
      
        imagejpeg($image, $destination, $quality);
        
        // var_dump($source);
        // var_dump($info);
        // exit;
    }
    catch(Exception $e) {
        echo 'Message: ' .$e->getMessage();
        error_log($e->getMessage(), 3, "./my-errors.log");

        // exit;
    }
      
}

function moveUploadedFile($directory, UploadedFile $uploadedFile)
{
    $directory = "./images/"; // must have . 
    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
    $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
    $filename = sprintf('%s.%0.8s', $basename, $extension);

    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

    return $filename;
}





// ---------------------------------------------------
//   FUNCTIONS 
// ---------------------------------------------------


function is_mobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}


function get_base(){
    global $SUB; 
    $PROTOCOL = isset($_SERVER['HTTPS']) ? "https://" : "http://"; 
    $SUB = is_local() ? "" : $SUB;
    return $PROTOCOL.$_SERVER["HTTP_HOST"].$SUB; // local to show image 
}

//=== append ?lang=en ===//
function lang_append(){
    global $lang; 
    return (($lang && $lang!='vi') ? '?lang='.$lang : '');
}


function get_base_lang(){
    // xem nhu khong dung nua
    global $lang; 
    return $lang ? '_'.$lang : '';
    // $base = get_base();
    // return $base; 
    // return ($lang=='' or $lang=='vi') ? $base : $base."/".$lang;
}





function get_url(){
    $PROTOCOL = isset($_SERVER['HTTPS']) ? "https://" : "http://"; 
    // $URL = $_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF']; //-> localhost//branch/c/a/
    $URL = $_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI']; //-> full url
    
    $URL = str_replace('/index.php', '', $URL);
    $URL = str_replace('/sitemap.xml', '', $URL);
    $URL = str_replace('/sitemap.php', '', $URL);
    return $PROTOCOL.$URL; 
}

// --- guzzle --- //
function init_client($endpoint){
    return $client = new Client([
        'base_uri' => $endpoint,
        'timeout'  => 6.0,
    ]);
}

// --- guzzle --- //
function curl_get($endpoint){
    //== pos.php/beta/master
    // echo $endpoint;
    $client = init_client($endpoint);
    $response = $client->get($endpoint);
    $body = $response->getBody();
    $body = json_decode($body);
    return $body; // {status: "", message:"", objects:[]}
}






?>