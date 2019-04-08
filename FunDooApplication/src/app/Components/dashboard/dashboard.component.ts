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
  present:boolean = false;
  constructor(private route: Router, private listview: ListService,
    private dashService: DashboardService,
    private labelsev: LabelService,
    public dialog: MatDialog,
    iconRegistry: MatIconRegistry,
    sanitizer: DomSanitizer,private cookieserv:CookieService ) {
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
     this.labels = res;
   })
  }
}
