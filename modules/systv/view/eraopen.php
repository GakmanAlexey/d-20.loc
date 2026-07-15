тут будет список эр

<?php
$era = $this->data_view["eraData"];
    echo "<br>";
    
    echo "ид эры: ";
    echo $era->getId();
    echo "<br>";
    echo "Название эры: ";
    echo $era->getName();
    echo "<br>";
    echo "Дата начала эры: ";
    echo $era->getStartYear();
    echo "<br>";
    echo "Дата конца эры: ";
    echo $era->getEndYear();
    echo "<br>";
    echo "Описание эры: ";
    echo $era->getDescription();
    echo "<br>";
    echo "Создано эры: ";
    echo $era->getCreatedAt();
    echo "<br>";
    echo "<br>";

?>