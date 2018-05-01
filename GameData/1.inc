<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/php/mysqli.inc";
$query = "SELECT t1.company, t2.member,
count(if(rank = 1, rank, null)) as rank1,
count(if(rank = 2, rank, null)) as rank2,
count(if(rank = 3, rank, null)) as rank3,
count(if(rank = 4, rank, null)) as rank4,
count(if(rank = 5, rank, null)) as rank5,
count(*) as total
from game_detail t1
LEFT JOIN (SELECT game_id, count(*) as member from game_detail group by game_id ) t2 on t1.game_id = t2.game_id
group by t1.company, t2.member order by member, company";


$companyList = array("UNMI",
 "마이닝 길드",
 "새턴 시스템",
 "시네마틱스",
 "에코라인",
 "인벤트릭스",
 "크레디코",
 "타르시스",
 "테렉터",
 "토르게이트",
 "포볼로그",
 "헬리온");

$data = array();
for($m = 2; $m <= 5; ++$m){
	foreach($companyList as $company){
		for($r = 1; $r <= $m; ++$r){
			$data[$m][$company][$r] = 0;
		}
		$data[$m][$company]["total"] = 0.0;
	}
}

if($result = $mysqli->query($query)){
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$member = $row["member"];
		for($i = 1; $i <= $member; ++$i){
			$data[$member][$row["company"]][$i] = $row["rank$i"];
			$data[$member][$row["company"]]["total"] += $row["rank$i"];
		}				
	}
}
echo "<br>";

uasort($data[2], "compare");
uasort($data[3], "compare");
uasort($data[4], "compare");
uasort($data[5], "compare");

for($mem = 2; $mem <= 5; ++ $mem){
	echo"
	<table id='member$mem' class='table table-striped'>
	<thead><tr >
		<th class='text-center' style='width:80px'>순위</th>
		<th style='width:150px'>기업</th>";
		for($i = 1; $i <= $mem; ++$i){
			echo "<th class='text-center'>".$i."등 횟수</th>";
		}
		echo "
		<th class='text-center'>총 횟수</th>
	</tr></thead>
	<tbody>";
	$index = 1;
		foreach($data[$mem] as $company => $rankList){
			echo "
			<tr>
			<td class='text-center'>".
				$index++."위
			</td>
			<td>
				$company
			</td>";
			for($r = 1; $r <= $mem; ++ $r){
				echo "<td class='text-center'>
				<div calss='nomal-view'>".$rankList[$r]."</div>";

				$value = $rankList["total"] == 0 ? 0 : round($rankList[$r]/$rankList["total"] * 100,3);
				echo "<div calss='calc-view'>$value %</div></td>";
			}
			echo "
			<td class='text-center'>$rankList[total]</td>
			</tr>";
		}

	echo "</tbody></table>";
}


?>

		
<?php
function compare($a, $b){
	if($a["total"] == 0 && $b["total"] == 0) return 0;
	if($a["total"] == 0) return 1;
	if($b["total"] == 0) return -1;
	for($i = 1; $i <= count($a) - 1; ++ $i){
		$r = compareNumber($a[$i] / $a["total"], $b[$i] / $b["total"]);
		if($r != 0) return $r;
	}
	return compareNumber($a["total"], $b["total"]);
}

function compareNumber($n1, $n2){
	if($n1 == $n2) return 0;
	return $n1 < $n2 ? 1 : -1;
}
?>