import { User } from './../../models/user';
import { AuthenticationService } from 'src/app/services/authentication.service';
import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl,  } from '@angular/forms';
import { Router } from '@angular/router';


@Component({
  selector: 'app-form-login',
  templateUrl: './form-login.component.html',
  styleUrls: ['./form-login.component.css']
})
export class FormLoginComponent implements OnInit {
  loginForm: FormGroup;
  constructor(
    private authenticationService: AuthenticationService,
    private router:Router

  ) {}

  ngOnInit() {
    this.loginForm = new FormGroup({
      username: new FormControl(''),
      password: new FormControl('')

    });
  }
  onSubmit()
  {
    const user =
    {
      username: this.loginForm.value.username,
      password: this.loginForm.value.password
    }as User
   // console.log(user);
   
    this.authenticationService.login(user).subscribe(
      (data) =>{
        console.warn(data);
        this.router.navigate(['/register']);
      },
     error =>
      {
        console.warn('connexion échoué !');
      }
      
    )
  }
  // getRoles()
  // {
  //   this.authenticationService.getRoles().subscribe( res =>

  //     console.warn(res)
  //   )
  // }
}
