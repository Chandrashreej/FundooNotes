import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { EditreminderComponent } from './editreminder.component';

describe('EditreminderComponent', () => {
  let component: EditreminderComponent;
  let fixture: ComponentFixture<EditreminderComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ EditreminderComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(EditreminderComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
