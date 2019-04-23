import { Injectable } from '@angular/core';
import { Subject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class LabelidService {

  constructor() { }
  labelName =new Subject();
  word:string;
  setLabelName(value:any){
    // debugger;
    this.word =value;
      this.labelName.next({data:value});
    
    
  } 

  getsetLabelName(){
    // debugger
    console.log("getlabelname",this.word)
    this.setLabelName(this.word);
    return this.labelName.asObservable();
  }
}
