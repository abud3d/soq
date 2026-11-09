<?php
declare(strict_types=1);
require dirname(__DIR__).'/src/bootstrap.php';
$app=new Nshir\App();$db=$app->db();$base=rtrim((string)(getenv('APP_URL')?:'https://nshir.com'),'/');
header('Content-Type: application/xml; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?>',PHP_EOL,'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">',PHP_EOL;
$emit=function(string $path,?string $date=null)use($base){echo '<url><loc>',htmlspecialchars($base.$path,ENT_XML1),'</loc>';if($date)echo'<lastmod>',substr($date,0,10),'</lastmod>';echo'</url>',PHP_EOL;};
$emit('/');
foreach($db->query("SELECT id FROM categories WHERE is_active=1") as$r)$emit('/category/'.$r['id']);
foreach($db->query("SELECT id FROM locations WHERE is_active=1") as$r)$emit('/location/'.$r['id']);
foreach($db->query("SELECT id,updated_at FROM ads WHERE status='published' ORDER BY id DESC LIMIT 50000") as$r)$emit('/ad/'.$r['id'],$r['updated_at']);
echo '</urlset>';
