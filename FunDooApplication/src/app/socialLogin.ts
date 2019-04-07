
import {
	AuthServiceConfig,
	FacebookLoginProvider,
	GoogleLoginProvider
} from "angular-6-social-login";
import {constant}from './constants/constants';
import { from } from "rxjs";
export function getAuthServiceConfigs() {
	let config = new AuthServiceConfig([
		{
			id: FacebookLoginProvider.PROVIDER_ID,
			provider: new FacebookLoginProvider(constant.facebookClientId)
		},

		{
			id: GoogleLoginProvider.PROVIDER_ID,
			provider: new GoogleLoginProvider(constant.googleClientId)
		}
	]);
	return config;
}
