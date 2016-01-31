<?php

global $letters, $word_hash, $word_length;

 function replace_hash_letters($letters, $worD){
     $word_length = strlen($worD);
     $letters_length = count($letters);
     //$letters = array($word[0], $word[$word_length]);


     for($i=0; $i<=$word_length-1; $i++) //cross chars of the given word
     {
         $exists=false;
         $char='';

         for($j=0; $j<=$letters_length; $j++) //cross letters of the given array letters
         {

             if($worD[$i]==$letters[$j]) //the letter exists in the word so i put it in its position
             {
                 $exists= true;
                 $char = $letters[$j];
             }


         }//end letters loop

         if($exists)
         {
             $worD[$i] = $char;
         }
         else
         {
             $worD[$i] = '_'; //otherwise I put a hash
         }

     }//end characters of word loop

     $word_hash = $worD;

     return $word_hash;

 }