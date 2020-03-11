import { Component, OnInit } from '@angular/core';
import { UserService } from 'src/app/services/user.service';

@Component({
  selector: 'app-affiche-user',
  templateUrl: './affiche-user.component.html',
  styleUrls: ['./affiche-user.component.css']
})
export class AfficheUserComponent implements OnInit {
  dataUsers: any;
  constructor(
   private userService: UserService
  	) { }

  ngOnInit() {
  	this.userService.getAll().subscribe(

      data =>{
      	this.dataUsers = data["hydra:member"];
      	console.log(data);
      }
  		)
  }
  onStatus(id: number)
  {
     this.userService.getStatus(id).subscribe(
     	data =>{
     	alert(JSON.stringify(data['message']));
     	this.userService.getAll().subscribe(

      data =>{
      	this.dataUsers = data;
      	console.log(data);
      }
  		)
     
     })
  }

}
