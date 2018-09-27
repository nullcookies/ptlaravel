import { Component,ViewChild } from '@angular/core';
import { ModalDirective } from 'ngx-bootstrap/modal';

@Component({
  selector: 'app-prompt',
  templateUrl:'./prompt.component.html',
  styleUrls:['./prompt.component.css']
   
})
export class PromptComponent{
  @ViewChild('staticModal') 
  public model:ModalDirective;
  public message:number;

  constructor() { 
    this.message = 0;
  }
  
  public showModal(){
    this.message += 1;
     this.model.show();

  }


}