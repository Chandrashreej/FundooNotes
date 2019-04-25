import { Injectable } from '@angular/core';
import { ServiceUrlService } from '../ServiceUrl/service-url.service';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class MoreoptionsService{


  constructor(private http: HttpClient,
    private sevriceurl: ServiceUrlService) { }
    moreoptions(n,value){
    debugger;
    let id = new FormData();
    id.append('id',n);
    id.append('value',value);
    return this.http.post((this.sevriceurl.host+this.sevriceurl.moreoptions), id);


  }
  coloringBackgroundinReminder(n,value){
    debugger;
    let id = new FormData();
    id.append('id',n);
    id.append('value',value);
    return this.http.post((this.sevriceurl.host+this.sevriceurl.coloringBackgroundForReminder), id);

  }
  dragNdropService(n,value){
    debugger;
    let id = new FormData();
    id.append('id',n);
    id.append('value',value);
    return this.http.post((this.sevriceurl.host+this.sevriceurl.dragNDrop), id);

    
    
    
    
  }
    
    
    dragNDrop
  
}
