<?php

function construct()
{
    load_model('index');
}

function searchProcessAction()
{
    load_view('searchProcess');
}

function filterProcessAction()
{
    load_view('filterProcess');
}

function updateProcessAction()
{
    load_view('updateProcess');
}
