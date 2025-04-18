<?php

use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = 'Учет Просто';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Учет Просто</h1>
        <p class="lead">ТЗ на вакансию Программист PHP (часть вторая)</p>
    </div>

    <div class="body-content">

        <p>
            <?= Html::a('Сделки', ['transactions/index'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Контакты', ['contacts/index'], ['class' => 'btn btn-success']) ?>
        </p>

        <div class="row">
            <div class="col-lg-3 mb-2">
                <h4>Меню</h4>
                <?php foreach ($menu as $m) { ?>
                    <div class="menu menu_<?= $m->guid ?> <?= $m->guid == 'menu_transactions' ? 'menu-active' : '' ?>">
                        <a href="#" onclick="onclick_menu('<?= $m->guid ?>')">
                            <?= $m->name ?>
                        </a>
                    </div>
                <?php } ?>
            </div>
            <div class="col-lg-3 mb-2">
                <h4>Список</h4>
                <div id="submenu-lists-blocks">
                    <?php foreach ($transactions as $key => $t) { ?>
                        <div class="submenu submenu_<?= $t->uuid ?> <?= $key == 0 ? 'submenu-active' : '' ?>">
                            <a href="#" onclick="onclick_submenu_transaction('<?= $t->uuid ?>')">
                                <?= $t->name ?>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-6">
                <h4>Содержимое</h4>
                <div id="contents" class="content">
                    <?php if(count($transactions) > 0) { ?>
                    <div class="row">
                        <div class="col-lg-6">
                            id сделки
                        </div>
                        <div class="col-lg-6">
                            <?= $transactions[0]->id ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            Наименование
                        </div>
                        <div class="col-lg-6">
                            <?= $transactions[0]->name ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            Сумма
                        </div>
                        <div class="col-lg-6">
                            <?= $transactions[0]->amount ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(count($contacts) > 0) { ?>
                        <?php foreach ($contacts as $contact) { ?>
                            <div class="row">
                                <div class="col-lg-6">
                                    id контакта: <?= $contact->id ?>
                                </div>
                                <div class="col-lg-6">
                                    <?= $contact->name ?> <?= $contact->surname ?>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
$script = <<< JS
    function onclick_menu(menu_guid)
    {
        $.ajax({ 
            url: '/web/get-submenu-lists',
            data: { 'menu_guid': menu_guid },
            type: 'POST',
            dataType: 'json',
            success: function(data){
                if(data.result) {                
                    //console.log("menu_guid = " + data.menu_guid);
                    if(data.menu_guid == 'menu_contacts') {
                        set_submenu_contacts(data.menu_guid, data.data);
                    }
                    else if(data.menu_guid == 'menu_transactions') {
                        set_submenu_transactions(data.menu_guid, data.data);
                    }
                    else {
                        console.log('error return menu_guid');
                    }
                }
            },
            error: function(){
                console.log('failure');
            }
        });
    }
    
    function select_menu(menu_guid)
    {
        $('.menu').each(function() {
            $(this).removeClass('menu-active');
         });

        $('.menu_' + menu_guid).addClass('menu-active')
    }
    
    function set_submenu_contacts(menu_guid, data) 
    {
        select_menu(menu_guid);
        $('#submenu-lists-blocks').html('');
        var submenu_lists_blocks = '';
        
        data.forEach(function(elem) {
            var surname = '';
            if(elem.surname !== null) surname = elem.surname;
            submenu_lists_blocks +=  
                '<div class="submenu submenu_' + elem.uuid + '">' +
                    '<a href="#" onclick="onclick_submenu_contact(\'' + elem.uuid + '\')">' + elem.name + ' ' + surname + 
                    '</a>' +
                '</div>';
        });
        
        $('#submenu-lists-blocks').html(submenu_lists_blocks);
        
        onclick_submenu_contact(data[0]['uuid']);
    }
    
    function set_submenu_transactions(menu_guid, data) 
    {
        select_menu(menu_guid);
        $('#submenu-lists-blocks').html('');
        var submenu_lists_blocks = '';
        
        data.forEach(function(elem) {
            submenu_lists_blocks +=  
                '<div class="submenu submenu_' + elem.uuid + '">' +
                    '<a href="#" onclick="onclick_submenu_transaction(\'' + elem.uuid + '\')">' + elem.name +
                    '</a>' +
                '</div>';
        });
        
        $('#submenu-lists-blocks').html(submenu_lists_blocks);
        
        onclick_submenu_transaction(data[0]['uuid']);
    }
   
    function onclick_submenu_transaction(uuid)
    {
        $.ajax({ 
            url: '/web/get-content-transaction',
            data: { 'transaction_uuid': uuid },
            type: 'POST',
            dataType: 'json',
            success: function(data){
                if(data.result) {                
                    set_submenu_transaction_blocks(uuid, data.transaction, data.contacts);
                }
            },
            error: function(){
                console.log('failure');
            }
        });
    }
    
    function set_submenu_transaction_blocks(uuid, transaction, contacts)
    {
        var submenu_transaction_blocks = '';

        submenu_transaction_blocks +=
            '<div class="row">' + 
                '<div class="col-lg-6">id сделки</div>' + 
                '<div class="col-lg-6">' + transaction.id + '</div>' + 
            '</div>';

        submenu_transaction_blocks +=
            '<div class="row">' + 
                '<div class="col-lg-6">Наименование</div>' + 
                '<div class="col-lg-6">' + transaction.name + '</div>' + 
            '</div>';

        submenu_transaction_blocks +=
            '<div class="row">' + 
                '<div class="col-lg-6">Сумма</div>' + 
                '<div class="col-lg-6">' + transaction.amount + '</div>' + 
            '</div>';

        contacts.forEach(function(elem) {
            var surname = '';
            if(elem.surname !== null) surname = elem.surname;
            submenu_transaction_blocks +=
                '<div class="row">' + 
                    '<div class="col-lg-6">id контакта: ' + elem.id + '</div>' +
                    '<div class="col-lg-6">' + elem.name + ' ' + surname + '</div>' +
                '</div>';
        });

        $('#contents').html(submenu_transaction_blocks);
        
        $('.submenu').each(function() {
           $(this).removeClass('submenu-active');
        });
         
        $('.submenu_' + uuid).addClass('submenu-active')
    }
    
    function onclick_submenu_contact(uuid)
    {
        $.ajax({ 
            url: '/web/get-content-contact',
            data: { 'contact_uuid': uuid },
            type: 'POST',
            dataType: 'json',
            success: function(data){
                if(data.result) {                
                    set_submenu_contact_blocks(uuid, data.contact, data.transactions);
                }
            },
            error: function(){
                console.log('failure');
            }
        });
    }

    function set_submenu_contact_blocks(uuid, contact, transactions)
    {
        var submenu_transaction_blocks = '';

        submenu_transaction_blocks +=
            '<div class="row">' + 
                '<div class="col-lg-6">id контакта</div>' + 
                '<div class="col-lg-6">' + contact.id + '</div>' + 
            '</div>';

        submenu_transaction_blocks +=
            '<div class="row">' + 
                '<div class="col-lg-6">Имя</div>' + 
                '<div class="col-lg-6">' + contact.name + '</div>' + 
            '</div>';

        var surname = '';
        if(contact.surname !== null) surname = contact.surname;
        
        submenu_transaction_blocks +=
            '<div class="row">' + 
                '<div class="col-lg-6">Фамилия</div>' + 
                '<div class="col-lg-6">' + surname + '</div>' + 
            '</div>';

        transactions.forEach(function(elem) {
            var surname = '';
            if(elem.surname !== null) surname = elem.surname;
            submenu_transaction_blocks +=
                '<div class="row">' + 
                    '<div class="col-lg-6">id сделки: ' + elem.id + '</div>' +
                    '<div class="col-lg-6">' + elem.name + '</div>' +
                '</div>';
        });
        
        $('#contents').html(submenu_transaction_blocks);
        
        $('.submenu').each(function() {
            $(this).removeClass('submenu-active');
        });
         
        $('.submenu_' + uuid).addClass('submenu-active')
    }

JS;

$this->registerJs($script, $this::POS_END);
?>
