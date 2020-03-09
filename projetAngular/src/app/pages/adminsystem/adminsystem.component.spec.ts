import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AdminsystemComponent } from './adminsystem.component';

describe('AdminsystemComponent', () => {
  let component: AdminsystemComponent;
  let fixture: ComponentFixture<AdminsystemComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AdminsystemComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AdminsystemComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
