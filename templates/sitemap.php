<?php  header("Content-type: application/xml");
echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?=get_base()?></loc>
        <priority>1.00</priority>
    </url>

    <?php foreach($pages as $p) { ?>
    <url>
        <loc><?=get_base()?>/page/<?=$p->slug?></loc>
        <changefreq>monthly</changefreq>
        <priority>1</priority>
    </url>
    <?php } ?>

    <?php foreach($posts as $p) { ?>
    <url>
        <loc><?=get_base()?>/post/<?=$p->slug?></loc>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    <?php } ?>

    <?php foreach($products as $p) { ?>
    <url>
        <loc><?=get_base()?>/product/<?=$p->slug?></loc>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <?php } ?>

</urlset>
