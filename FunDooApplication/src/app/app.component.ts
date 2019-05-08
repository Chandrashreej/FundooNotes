import { Component } from '@angular/core';
import { MessagingService } from './Services/messaging.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss'],
})
export class AppComponent {
  message;

  constructor(private msgService: MessagingService) {}

  ngOnInit() {
    this.msgService.getPermission()
    this.msgService.receiveMessage()
    this.message = this.msgService.currentMessage
  }
}
