<?php
$example_persons_array = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
];
//Функция для разбиения ФИО на части
echo "Разбиваем инициалы на части <br>";
function getPartsFromFullname ($fullName) {
    $initials = ['surname', 'name', 'patronomyc'];
    return array_combine($initials,explode(" ", $fullName));
}

$divideName = getPartsFromFullname ($example_persons_array[random_int(0, count($example_persons_array)-1)]['fullname']);
print_r($divideName);

//Функция для соединения ФИО в одну строку
function getFullnameFromParts ($surname, $name, $patronomyc) {
    return $surname . ' ' . $name . ' ' . $patronomyc;
}
echo '<br><br>';
echo "Получаем полное имя: <br>";
$getFullName = getFullnameFromParts($divideName['surname'], $divideName['name'], $divideName['patronomyc']);
print_r($getFullName);
echo '<br><br><br><br>';


//Функия для сщкращения ФИО
function getShortName ($fullName) {
  
$divideName2 = getPartsFromFullname($fullName);
 return $divideName2['name'] . ' ' . mb_substr($divideName2['surname'], 0, 1);
}

$shortName = getShortName($example_persons_array[random_int(0, count($example_persons_array)-1)]['fullname']);
echo "Сокращаем ФИО:<br>";
print_r($shortName);
echo '<br><br><br><br>';

//Функция определения пола по ФИО
function getGenderFromName ($fullName) {
  $divideName3 = getPartsFromFullname($fullName);
  $gender = 0;
//признаки женского пола
    if (mb_substr($divideName3['patronomyc'], -3, 3) == 'вна') {
     --$gender;
  };
  if (mb_substr($divideName3['name'], -1, 1) == 'а') {
     --$gender;
   };
   if (mb_substr($divideName3['surname'], -2, 2) == 'ва') {
     --$gender;
   };
//признаки мужского пола
if (mb_substr($divideName3['patronomyc'], -2, 2) == 'ич') {
     ++$gender;
   };
   if (mb_substr($divideName3['name'], -1, 1) == 'й' || mb_substr($divideName3['name'], -1, 1) == 'н') {
     ++$gender;
    };
    if (mb_substr($divideName3['surname'], -1, 1) == 'в') {
     ++$gender;
    };
    switch($gender <=> 0){
        case 1:
            return 'Мужчина';
            break;
        case -1:
            return 'Женщина';
            break;
        default:
            return'Не удалось определить';
    }   
  
}
for ($i=0;$i<count($example_persons_array);$i++){
$definGender[$example_persons_array[$i]['fullname']] = getGenderFromName($example_persons_array[$i]['fullname']);
}
echo 'Определяем пол по ФИО<br>';
print_r($definGender);
echo '<br><br><br><br>';


echo 'Определяем возрастно-половой состав<br>';

function getGenderDescription ($array) {
    $mans = array_filter($array, function ($person) {
    return getGenderFromName($person['fullname']) == 'Мужчина';
    });

    $womens = array_filter($array, function ($person) {
    return getGenderFromName($person['fullname']) == 'Женщина';
    });

    $unknown = array_filter($array, function ($person) {
    return getGenderFromName($person['fullname']) == 'Не удалось определить';
    });
 
    $countingMans = round(count($mans)*100/count($array), 1);
    $countingWomens = round(count($womens)*100/count($array), 1);
    $countingUnknow = round(count($unknown)*100/count($array), 1);

    
 echo <<<HEREDOCLETTER
Гендерный состав аудитории:<br>
---------------------------<br>
Мужчины - $countingMans%<br>
Женщины - $countingWomens%<br>
Не удалось определить - $countingUnknow%<br>
HEREDOCLETTER;
};
$genderConten = getGenderDescription($example_persons_array);
print_r($genderConten);
echo '<br><br><br><br>';

echo 'Производим идеальный подбор пары<br>';
function getPerfectPartner ($surname,$name,$patronomyc,$array) {
    //Соединяем полное имя человека
    $wholeName = getFullnameFromParts($surname, $name, $patronomyc);
    //Определяем пол человека
    $personGender = getGenderFromName($wholeName);
    //Ищем случайного партнёра
    $randomPartner = $array[random_int(0, count($array)-1)]['fullname'];
    //Определяем пол партнёра
    $partnerGender = getGenderFromName($randomPartner);
    //Проверяем что пол обоих партнёров разный
    while ($personGender === $partnerGender || $partnerGender === 0 || $wholeName === $randomPartner)
    {
        $randomPartner = $array[random_int(0, count($array)-1)]['fullname'];
        $genderPartner = getGenderFromName($randomPartner);
    }
    //Сокращаем имена партнёров
    $shortFirstName = getShortName($wholeName);
    $shortSecondName = getShortName($randomPartner);
    $compatibility = mt_rand(50, 100) + mt_rand(0, 100)/100;   
    
    echo 'Результат функции идеального подбора пары' . "<br>";
    echo $shortFirstName . " + " . $shortSecondName . " = " . "<br>";
    echo "♡". " Идеально на ". $compatibility. "% " ."♡";
    return 0;
} 

$divideArray = getPartsFromFullname($example_persons_array[random_int(0, count($example_persons_array)-1)]['fullname']);
$createCouple = getPerfectPartner($divideArray['surname'], $divideArray['name'], $divideArray['patronomyc'], $example_persons_array);

?>
























































