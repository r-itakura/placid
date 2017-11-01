import { Injectable } from "@angular/core";

import { Admin } from './admin';

@Injectable()
export class LoginService {
    getAdmin() : Admin {
        return {
            admId: 'hoge@example.com',
            admPass: ''
        };
    }
}