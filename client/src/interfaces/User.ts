interface User {
  id: number | null;
  first_name: string;
  last_name: string;
  username: string;
  email: string;
  password: string;
  profile_picture: string | null;
  is_admin: boolean;
  user_type: number;
}

export default User;
