import { Injectable } from '@angular/core';
import { Subject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class SearchService {

  constructor() { }
  search =new Subject();
  word:string;
  setSercher(value:any){
    debugger;
    this.word =value;
      this.search.next({data:value});
    
  } 

  getserch(){
    debugger
    this.setSercher(this.word);
    return this.search.asObservable();
  }
}
