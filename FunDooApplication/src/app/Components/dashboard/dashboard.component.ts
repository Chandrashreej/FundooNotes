import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ListService } from 'src/app/Services/list.service';
import { DashboardService } from 'src/app/Services/dashboardService/ServiceNotes';
import { MatDialogConfig, MatDialog, MatIconRegistry } from '@angular/material';
import { DomSanitizer } from '@angular/platform-browser';


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
  firstname: any;
  constructor(private route: Router, private listview: ListService,private dashService: DashboardService,
    public dialog: MatDialog,
    iconRegistry: MatIconRegistry,
    sanitizer: DomSanitizer,) {
    this.changeView();
  }

  ngOnInit() {
    debugger;
    this.email = localStorage.getItem("email");
    let name = this.dashService.getname(this.email);
    name.subscribe((res: any) => {
      debugger;
      this.firstname = res;

      
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
}
