<?php

function create($class, $attr =[]){
    return $class::factory()->create();
}