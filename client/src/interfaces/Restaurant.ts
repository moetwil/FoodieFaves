interface Restaurant {
  id: number | null;
  name: string;
  street: string;
  house_number: string;
  city: string;
  zip_code: string;
  country: string;
  phone_number: string;
  owner_id: number | null;
  profile_picture: string | null;
  restaurant_type_id: number;
}

export default Restaurant;
