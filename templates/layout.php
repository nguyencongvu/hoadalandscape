<!DOCTYPE html>
<?php global $lang, $DEFAUL_LANG; ?>
<html lang="<?=$_SESSION['lang'] ? $_SESSION['lang'] : $DEFAUL_LANG ?>">
<head>
    <meta charset="UTF-8">
    <base href="<?=get_base();?>/">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="<?=$site->meta_robots?>">
    <meta name="theme-color" content="<?=$site->color_primary?>">

    <!-- seo 
    ===============================-->
    <title><?=$site->site_title?></title>
    <meta name="description" content="<?=$site->site_description?>">
    <link rel="shortcut icon" href="<?=$site->favicon ? $site->favicon : get_base().'/favicon.ico'?>" type="image/x-icon">
    <link rel="apple-touch-icon" href="<?=$site->favicon ? $site->favicon : get_base().'/favicon.ico'?>">
    <link rel="canonical" href="<?=get_url()?>" />
    <!-- og 
    ======================================================= -->
    <meta property="og:url" content="<?=get_url()?>" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="<?=$site->image?>" />
    <meta property="og:site_name" content="<?=$site->site_name?>" />
    <meta property="og:title" content="<?=$site->site_title?>" />
    <meta property="og:description" content="<?=$site->site_description?>" />

    <!-- twitter cards  
    ======================================== -->
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:image" content="<?=$site->image?>" />
    <meta name="twitter:title" content="<?=$site->site_title?>" />
    <meta name="twitter:description" content="<?=$site->site_description?>" />
    
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400|Material+Icons|Montserrat:700|Krub:500,700" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/quasar@1.15.15/dist/quasar.min.css" rel="stylesheet" type="text/css">
    
    <?php if ($site->embed_ga) { ?> 
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','<?=$site->embed_ga?>');</script>
        <!-- End Google Tag Manager -->
    <?php } ?>

    <style type="text/css" media="print">
        body {
            background: white;
            /* color: red; */
        }
        table { 
            border-collapse: collapse;
            width: 100%; 

        } 
        th,  td {
            padding: 4px;
            border: solid 1px #ccc;
        }
    </style>
</head>
<body id="body"> 
    <?=$content?>
    <!-- embed code   -->
    <?php if ($site->embed_fb) { ?> 
      <div class="bg-black">
      <?=$site->embed_fb?>
      </div>
    <?php } ?>

    <!-- google tag end  -->
    <?php if ($site->embed_ga) { ?> 
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?=$site->embed_ga?>"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
    <?php } ?>
</body>
</html>