import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { EmptycontentComponent } from './emptycontent.component';

describe('EmptycontentComponent', () => {
  let component: EmptycontentComponent;
  let fixture: ComponentFixture<EmptycontentComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ EmptycontentComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(EmptycontentComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
