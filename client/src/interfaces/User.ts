interface User {
  id: number;
  first_name: string;
  last_name: string;
  username: string;
  email: string;
  password: string;
  profile_picture: string;
  is_admin: boolean;
  user_type: string;
}

export default User;
