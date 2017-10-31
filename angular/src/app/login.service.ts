import { Injectable } from "@angular/core";

import { Admin } from './admin';

@Injectable()
export class LoginService {
    getAdmin() : Admin[] {
        return [
            {
                admId : 'admin3',
                admPass : 'admin3'
            },
        ];
    }
}