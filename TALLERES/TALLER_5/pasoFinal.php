<?php
class Estudiante {
    private int $id;
    private string $nombre;
    private int $edad;
    private string $carrera;
    private array $materias=[];
    private array $flags=[];

    public function __construct(int $id,string $nombre,int $edad,string $carrera){
        $this->id=$id; $this->nombre=$nombre; $this->edad=$edad; $this->carrera=$carrera;
    }
    public function agregarMateria(string $m,float $c){
        $this->materias[$m]=$c;
        if($c<70)$this->flags['en_riesgo']=true;
        if($c>=90)$this->flags['honor_roll']=true;
    }
    public function obtenerPromedio():float{ return empty($this->materias)?0:array_sum($this->materias)/count($this->materias); }
    public function obtenerDetalles():array{ return ['id'=>$this->id,'nombre'=>$this->nombre,'edad'=>$this->edad,'carrera'=>$this->carrera,'materias'=>$this->materias,'promedio'=>$this->obtenerPromedio(),'flags'=>$this->flags]; }
    public function __toString():string{ return "{$this->nombre} ({$this->carrera}) - Promedio: ".number_format($this->obtenerPromedio(),2);}
}

class SistemaGestionEstudiantes {
    private array $estudiantes=[];
    private array $graduados=[];

    public function agregarEstudiante(Estudiante $e){ $this->estudiantes[$e->obtenerDetalles()['id']]=$e; }
    public function obtenerEstudiante(int $id):?Estudiante{ return $this->estudiantes[$id]??null; }
    public function listarEstudiantes():array{ return array_values($this->estudiantes); }
    public function calcularPromedioGeneral():float{ return empty($this->estudiantes)?0:array_sum(array_map(fn($e)=>$e->obtenerPromedio(),$this->estudiantes))/count($this->estudiantes); }
    public function obtenerMejorEstudiante():?Estudiante{ return empty($this->estudiantes)?null:array_reduce($this->estudiantes,fn($a,$b)=>(!$a||$b->obtenerPromedio()>$a->obtenerPromedio())?$b:$a); }
    public function generarReporteRendimiento():array{
        $materias=[];
        foreach($this->estudiantes as $e){
            foreach($e->obtenerDetalles()['materias'] as $m=>$c){ $materias[$m][]=$c; }
        }
        $reporte=[];
        foreach($materias as $m=>$c){ $reporte[$m]=['promedio'=>array_sum($c)/count($c),'max'=>max($c),'min'=>min($c)]; }
        return $reporte;
    }
    public function graduarEstudiante(int $id){ if(isset($this->estudiantes[$id])){$this->graduados[$id]=$this->estudiantes[$id]; unset($this->estudiantes[$id]);} }
    public function generarRanking():array{ $r=$this->estudiantes; usort($r,fn($a,$b)=>$b->obtenerPromedio()<=>$a->obtenerPromedio()); return $r; }
    public function buscarEstudiantes(string $t):array{
        $t=strtolower($t);
        return array_filter($this->estudiantes, fn($e)=>str_contains(strtolower($e->obtenerDetalles()['nombre']),$t)||str_contains(strtolower($e->obtenerDetalles()['carrera']),$t));
    }
    public function guardarEnJSON(string $archivo):void{
        $data=array_map(fn($e)=>$e->obtenerDetalles(),$this->estudiantes);
        file_put_contents($archivo,json_encode($data,JSON_PRETTY_PRINT));
    }
    public function cargarDesdeJSON(string $archivo):void{
        if(file_exists($archivo)){
            $data=json_decode(file_get_contents($archivo),true);
            foreach($data as $d){
                $e=new Estudiante($d['id'],$d['nombre'],$d['edad'],$d['carrera']);
                foreach($d['materias'] as $m=>$c) $e->agregarMateria($m,$c);
                $this->agregarEstudiante($e);
            }
        }
    }
}

// Prueba del sistema
$sistema=new SistemaGestionEstudiantes();
for($i=1;$i<=10;$i++){
    $e=new Estudiante($i,"Estudiante $i",rand(18,25),["Ingeniería","Medicina","Derecho","Arquitectura","Contabilidad"][rand(0,4)]);
    foreach(["Matemáticas","Física","Programación","Historia","Literatura"] as $m) $e->agregarMateria($m,rand(60,100));
    $sistema->agregarEstudiante($e);
}

echo "Listado de estudiantes:\n";
foreach($sistema->listarEstudiantes() as $e) echo $e."\n";

echo "\nPromedio general: ".number_format($sistema->calcularPromedioGeneral(),2)."\n";
echo "\nMejor estudiante: ".$sistema->obtenerMejorEstudiante()."\n";

echo "\nRanking:\n";
foreach($sistema->generarRanking() as $k=>$e) echo ($k+1).". ".$e."\n";

$sistema->guardarEnJSON("estudiantes.json");
echo "\nDatos guardados en estudiantes.json\n";
?>
