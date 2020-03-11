import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl,  } from '@angular/forms';
import { ProfileService } from 'src/app/services/profile.service';
import { UserService } from 'src/app/services/user.service';


@Component({
  selector: 'app-form-register',
  templateUrl: './form-register.component.html',
  styleUrls: ['./form-register.component.css']
})
export class FormRegisterComponent implements OnInit {
  registerForm: FormGroup;
  profiles:any;
  constructor(
    private profileService: ProfileService,
    private userService: UserService
  ) { }

  ngOnInit() {
     this.registerForm = new FormGroup({
     	
     	username: new FormControl(''),
     	password: new FormControl(''),
     	login:    new FormControl(''),
     	profile:  new FormControl('')

     });
     this.profileService.getProfile().subscribe(
       data =>
          {
            this.profiles = data;
            // console.log(data);

            // console.log(data);
          })
  }
  onSubmit()
  {
    const donnes=
    {
      username: this.registerForm.value.username,
      password: this.registerForm.value.password,
      login:    this.registerForm.value.login,
      profile: `api/profiles/${this.registerForm.value.profile}`

    }
    console.log(donnes);
    this.userService.register(donnes).subscribe(data => 
      {
        alert(JSON.stringify(data));
      })
  }

}
