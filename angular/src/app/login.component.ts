import { Component } from '@angular/core';

@Component({
    selector: "my-app",
    template: `
        <form #myForm="ngForm" (ngSubmit)="show()" novalidate>
            <div>
                <label for="mail">メールアドレス：</label><br />
                <input id="mail" name="mail" type="email"
                       [(ngModel)]="user.mail" #mail="ngModel" required email />
                <span *ngIf="mail.errors?.required">メールアドレスは必須です。</span>

                <!--hasErrorメソッドの場合-->
                <!--<span *ngIf="mail.hasError('required')">メールアドレスは必須です。</span>-->

                <span *ngIf="mail.errors?.email">
        メールアドレスを正しい形式で入力してください。</span>
            </div>
            <div>
                <label for="passwd">パスワード：</label><br />
                <input id="passwd" name="passwd" type="password"
                       [(ngModel)]="user.passwd"
                       required minlength="6" #passwd="ngModel" />
                <!--<span *ngIf="passwd.errors?.required">
                  パスワードは必須です。</span>-->
                <span *ngIf="passwd.errors?.required&& passwd.dirty">
        パスワードは必須です。</span>
                <span *ngIf="passwd.errors?.minlength">
        パスワードは6文字以上で入力してください。</span>
            </div>
            <div>
                <input type="submit" value="送信"
                       [disabled]="myForm.invalid" />

                <!--サブミット済みかどうかを判定-->
                <!--<input type="submit" value="送信" 
                  [disabled]="myForm.invalid|| myForm.submitted" />-->

                <!--pristine／dirtyプロパティを利用したリセットボタン-->
                <!--<input type="reset" value="リセット" [disabled]="myForm.pristine" />-->
                <!--<input type="reset" value="リセット" [disabled]="!myForm.dirty" />-->
            </div>
        </form>
        <!-- <pre>{{myForm.value | json}}</pre> -->


    `
})
export class LoginComponent {
    user = {
        mail: 'hoge@example.com',
        passwd: '',
    };

    show() {
        console.log('メールアドレス：' + this.user.mail);
        console.log('パスワード：' + this.user.passwd);
    }
}