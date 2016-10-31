<?php

class ConsoleKernel {

   public static function commands(){

      return [
         new Clooder\Command\WebsocketCommand()
      ];
   }

   public static function getRootKernel(){
      return __DIR__;
   }
}
