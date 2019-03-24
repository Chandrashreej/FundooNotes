import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ListService } from 'src/app/Services/list.service';


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

  constructor(private route: Router, private listview: ListService) {
    this.changeView();
  }

  ngOnInit() {
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
