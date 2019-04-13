import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ListService } from 'src/app/Services/list.service';
import { DashboardService } from 'src/app/Services/dashboardService/ServiceNotes';
import { MatDialogConfig, MatDialog, MatIconRegistry } from '@angular/material';
import { DomSanitizer } from '@angular/platform-browser';
// import { LabelComponent } from '../label/label.component';
import { LabelComponent } from 'src/app/Components/label/label.component';
import { LabelService } from 'src/app/Services/label.service';
import { LabelsModel } from 'src/app/Models/labels.model';
import { CookieService } from 'ngx-cookie-service';
import { SearchService } from 'src/app/Services/search.service';
import { NotesModel } from 'src/app/Models/Notes.model';




@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss']
})
export class DashboardComponent implements OnInit {
  showFiller = false;

  getToken: string;
  refreshFlag: boolean = true;
  grid: boolean = false;
  list: boolean = true;
email:string;
name:string;
labels: LabelsModel[]=[];
  firstname: any;
  image:string;
  present:boolean = true;
  imagepre: boolean = false;
  notelist: NotesModel[];
  view: {};
  constructor(private route: Router, private listview: ListService,
    private search:SearchService,
    private dashService: DashboardService,
    private labelsev: LabelService,
    public dialog: MatDialog,
    iconRegistry: MatIconRegistry,
    sanitizer: DomSanitizer,private cookieserv:CookieService) {
    this.changeView();
    this.image = this.cookieserv.get("image");
  }
  value
  ngOnInit() {
    //debugger;
    this.email = localStorage.getItem("email");
    let name = this.dashService.getname(this.email);
    name.subscribe((res: any) => {
      debugger;
      this.firstname = res;

      
    });
    this.fetchLabel();
    debugger;
   this.image = this.cookieserv.get("image");
   this.value = this.cookieserv.get("name") + " \n "+ this.cookieserv.get("email");
  
   this.notesDisplaying();
 this.fetchImage();
  }

  notesDisplaying() {

    const email = localStorage.getItem('email');

    let getnotes = this.dashService.fetchnotes(email);

    getnotes.subscribe((res: any) => {

      console.log("res", res);

      this.notelist = res;

   

    });
  }

  openLabel(){
    const config = new MatDialogConfig();
    config.width="600px";
    config.height="250px";
    // config.data ={data:this.uid};
    // const label = this.dialog.open(LabelsComponent,config);
  }
  notes() {
    this.getToken = localStorage.getItem("token");
    return this.getToken;
    
  }
  logout() {
    localStorage.removeItem("token");
    this.route.navigate(['/login']);
    this.cookieserv.deleteAll();
  }

  refresh() {
    this.refreshFlag = !this.refreshFlag;
  }
  changeView() {

    if (this.list == true) {
      this.grid = true;
      this.list = false;
    }
    else {
      this.list = true;
      this.grid = false;
    }

    this.listview.gridview();
  }
  label(){
    this.email = localStorage.getItem("email");
    console.log('hi');
    const config = new MatDialogConfig();
    config.width="300px";
    config.panelClass = 'label-dialog-container'
    config.data ={data:this.email};
    const label = this.dialog.open(LabelComponent,config);
  }
  fetchLabel() {
    this.email = localStorage.getItem("email");
    debugger
     let fetchobs = this.labelsev.fetchLabel(this.email);

     fetchobs.subscribe((res: any) => {
      debugger
      this.labels = res;
    })
  }
  fetchImage(){
    this.email = localStorage.getItem("email");
    let fetchobs = this.dashService.fectImageService(this.email);

    fetchobs.subscribe((res: any) => {
     debugger
     this.mainimage = res;
   })
  }
  serchingterm
  sendSearchData(){
    debugger;
    if(this.serchingterm == undefined)
    {

    }
    else{
         this.search.setSercher(this.serchingterm);
    }


  }


  closeSearch(){
    debugger;
    this.serchingterm="";
    // this.route.navigate(['/notes']);
  }
mainimage;
imageid;

  selectedImage(event, id){
    debugger;
    this.imageid = id;
    var files = event.target.files;
    var file = files[0];
    if(files && file)
    {
      var reader = new FileReader();
      reader.onload =this._handleReaderLoaded.bind(this);
      reader.readAsBinaryString(file);

    }
  }

  base64textString

  _handleReaderLoaded(readerEvt){

    debugger;

    var binarstring = readerEvt.target.result;

    this.base64textString = btoa(binarstring);
    this.notelist.forEach(element=>{
      if(element.id == this.imageid )
      {
        debugger
        element.image = "data:image/jpeg;base64,"+this.base64textString;
      }
    });

    if(this.imageid == "01")
    {
      this.present = false;
      this.imagepre =true;
      this.mainimage = "data:image/jpeg;base64,"+this.base64textString;

      this.email = localStorage.getItem("email");
    let setchobs = this.dashService.setImageService(this.email, this.mainimage);
    setchobs.subscribe((res: any) => {
      debugger
      // this.labels = res;
    });

    }
    else{

    }
  }


}