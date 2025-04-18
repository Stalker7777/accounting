<?php

/** @var yii\web\View $this */

$this->title = 'Учет Просто';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Учет Просто</h1>
        <p class="lead">ТЗ на вакансию Программист PHP (часть первая)</p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-3 mb-2">
                <h4>Тема</h4>
                <?php foreach ($topics as $topic) { ?>
                    <div class="topic topic_<?= $topic->id ?> <?= $topic->id == 1 ? 'topic-active' : '' ?>">
                        <a href="#" onclick="onclick_topics(<?= $topic->id ?>)">
                            <?= $topic->name ?>
                        </a>
                    </div>
                <?php } ?>
            </div>
            <div class="col-lg-3 mb-2">
                <h4>Подтема</h4>
                <div id="subtopics-blocks">
                <?php foreach ($subtopics as $subtopic) { ?>
                    <div class="subtopic subtopic_<?= $subtopic->id ?> <?= $subtopic->id == 1 ? 'subtopic-active' : '' ?>">
                        <a href="#" onclick="onclick_subtopics(<?= $subtopic->id ?>)">
                            <?= $subtopic->name ?>
                        </a>
                    </div>
                <?php } ?>
                </div>
            </div>
            <div class="col-lg-6">
                <h4>Содержимое</h4>
                <div id="contents" class="content"><?= $contents->content ?></div>
            </div>
        </div>

    </div>
</div>

<?php
$script = <<< JS
    function onclick_topics(topic_id)
    {
        $.ajax({ 
            url: '/web/get-subtopics',
            data: { 'topic_id': topic_id },
            type: 'POST',
            dataType: 'json',
            success: function(data){
                if(data.result) {                
                    set_subtopics_blocks(topic_id, data.data);
                }
            },
            error: function(){
                console.log("failure");
            }
        });
    }
    
    function set_subtopics_blocks(topic_id, data)
    {
        $('#subtopics-blocks').html('');
        
        var subtopics_blocks = '';
        
        data.forEach(function(elem) {
            subtopics_blocks += '<div class="subtopic subtopic_' + elem.subtopics_id + '"><a href="#" onclick="onclick_subtopics(' + elem.subtopics_id + ')">' + elem.subtopics_name + '</a></div>'; 
        });
        
        $('#subtopics-blocks').html(subtopics_blocks);
        
        $('.topic').each(function() {
            $(this).removeClass('topic-active');
         });
         
         $('.topic_' + topic_id).addClass('topic-active')
        
        onclick_subtopics(data[0]['subtopics_id']);
    }
    
    function onclick_subtopics(subtopic_id)
    {
        $.ajax({ 
            url: '/web/get-contents',
            data: { 'subtopic_id': subtopic_id },
            type: 'POST',
            dataType: 'json',
            success: function(data){
                if(data.result) {                
                    set_contents(subtopic_id, data.content);
                }
            },
            error: function(){
                console.log("failure");
            }
        });
    }
    
    function set_contents(subtopic_id, content)
    {
         $('.subtopic').each(function() {
            $(this).removeClass('subtopic-active');
         });
         
         $('.subtopic_' + subtopic_id).addClass('subtopic-active')
         
         $('#contents').html(content);
    }
JS;

$this->registerJs($script, $this::POS_END);
?>
