import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';


@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss']
})
export class DashboardComponent implements OnInit {
  showFiller = false;
  getToken: string;
  refreshFlag: boolean =true;
  constructor( private route: Router) { }

  ngOnInit() {
  }
notes(){
  this.getToken = localStorage.getItem("token");
  return this.getToken;
}
logout(){
  localStorage.removeItem("token");
  this.route.navigate(['/login']);
}

refresh(){
  this.refreshFlag =!this.refreshFlag;
}
}
