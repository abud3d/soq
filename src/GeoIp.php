<?php
declare(strict_types=1);
namespace Nshir;
use GeoIp2\Database\Reader;
final class GeoIp {
 public function __construct(private App $app){}
 public function locate(string $ip):?array{
  if(!filter_var($ip,FILTER_VALIDATE_IP))return null;$file=(string)getenv('GEOIP_DB');if(!$file||!is_readable($file)||!class_exists(Reader::class))return null;
  try{$r=(new Reader($file))->city($ip);$gid=$r->city->geonameId;$cc=$r->country->isoCode;
   $q=$this->app->db()->prepare('SELECT id,parent_id,name,type FROM locations WHERE geoname_id=? LIMIT 1');$q->execute([$gid]);$local=$q->fetch()?:null;
   return ['country_code'=>$cc,'city_geoname_id'=>$gid,'city_en'=>$r->city->name,'city_ar'=>$r->city->names['ar']??null,'subdivision_code'=>$r->mostSpecificSubdivision->isoCode,'location'=>$local];
  }catch(\Throwable){return null;}
 }
}
