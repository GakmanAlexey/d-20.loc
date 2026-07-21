Источник

<?php
 $source = $this->data_view["sourceData"];
    echo "<br>";
    
    echo "ид Источника: <a href='/nexus/dnd5e/source/open/?source=".$source->getId()."'>";
    echo $source->getId();
    echo "</a><br>";

    
    echo "Русскоязычное название источника: ";
    echo $source->getNameRu();
    echo "<br>";
    
    echo "Латинское наименование источника: ";
    echo $source->getName();
    echo "<br>";
    
    echo "Сокращеное уникальное наименование: ";
    echo $source->getSlug();
    echo "<br>";
    
    echo "Прификс: ";
    echo $source->getMicroLabel();
    echo "<br>";
    
    echo "Описание: ";
    echo $source->getDescription();
    echo "<br>";
    
    echo "Статус: ";
    echo $source->getStatus();
    echo "<br>";
    
    echo "Ид изображения: ";
    echo $source->getIdIMG();
    echo "<br>";
    
    echo "Дата публикации: ";
    echo $source->getDatePublisher();
    echo "<br>";
    
    echo "Студия: ";
    echo $source->getStudio();
    echo "<br>";
    
    echo "Дата создания: ";
    echo $source->getDateCreate();
    echo "<br>";
    
    echo "Дата редактирования: ";
    echo $source->getDateUpdate();
    echo "<br>";

    echo "<br>";


?>