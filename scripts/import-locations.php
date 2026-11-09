<?php
declare(strict_types=1);
require dirname(__DIR__).'/src/bootstrap.php';
$app=new Nshir\App();$db=$app->db();
$file=$argv[1]??'';if(!$file||!is_file($file)){fwrite(STDERR,"Usage: php scripts/import-locations.php locations.csv\n");exit(1);}
$h=fopen($file,'rb');$head=fgetcsv($h);$required=['country_code','country_ar','region_code','region_ar','city_code','city_ar','governorate_code','governorate_ar'];
if($head!==$required){fwrite(STDERR,"CSV header is invalid. See database/data/README.md\n");exit(1);}
$slug=fn(string $s)=>trim(strtolower(preg_replace('/[^a-zA-Z0-9]+/','-',$s)??''),'-');
$findOrCreate=function(?int $parent,string $type,string $name,string $code)use($db,$slug):int{
 $s=$slug($code);$q=$db->prepare('SELECT id FROM locations WHERE '.($parent===null?'parent_id IS NULL':'parent_id=?').' AND slug=? LIMIT 1');$q->execute($parent===null?[$s]:[$parent,$s]);$id=$q->fetchColumn();if($id)return(int)$id;
 $q=$db->prepare('INSERT INTO locations(parent_id,type,name,slug) VALUES(?,?,?,?)');$q->execute([$parent,$type,$name,$s]);return(int)$db->lastInsertId();
};
$db->beginTransaction();$n=0;
try{while(($r=fgetcsv($h))!==false){if(count($r)!==8)continue;[$cc,$ca,$rc,$ra,$tc,$ta,$gc,$ga]=array_map('trim',$r);if(!$cc||!$ca)continue;
 $country=$findOrCreate(null,'country',$ca,$cc);
 $region=$country;if($rc&&$ra)$region=$findOrCreate($country,'region',$ra,$cc.'-'.$rc);
 $city=$region;if($tc&&$ta)$city=$findOrCreate($region,'city',$ta,$cc.'-'.$rc.'-'.$tc);
 if($gc&&$ga)$findOrCreate($city,'governorate',$ga,$cc.'-'.$rc.'-'.$tc.'-'.$gc);$n++;}
 $db->commit();echo "Imported $n rows\n";
}catch(Throwable $e){$db->rollBack();throw $e;}
