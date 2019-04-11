import { Component, OnInit } from '@angular/core';
import { DashboardService } from 'src/app/Services/dashboardService/ServiceNotes';
import { ListService } from 'src/app/Services/list.service';
import { SearchService } from 'src/app/Services/search.service';

@Component({
  selector: 'app-emptycontent',
  templateUrl: './emptycontent.component.html',
  styleUrls: ['./emptycontent.component.scss']
})
export class EmptycontentComponent implements OnInit {
  notelist: string[];
  view;

  constructor(private dashService: DashboardService,

    private search:SearchService,

    private listview: ListService) { }

  ngOnInit() {

    this.sercher();
  }

  notesDisplaying() {
    debugger;
    const email = localStorage.getItem('email');

    let getnotes = this.dashService.fetchnotes(email);

    getnotes.subscribe((res: any) => {

      console.log("res", res);

      this.notelist = res as string[];
    });
  }
  searchterm;
  sercher() {
    debugger;
    this.notesDisplaying();

    this.search.getserch().subscribe((res => {
     

      this.view = res;

      this.searchterm = this.view.data;


      console.log(this.searchterm)
    }));
  }

}
