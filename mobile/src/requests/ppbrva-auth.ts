import axios from './axios';
import { dispatch } from '../store';
import { saveAccessToken, saveDashboard, saveSocial } from '../store/settings';
import { MeProps, saveLocation, saveMe, savePlan } from '../store/user';

export const fetchMe = () => {
  return new Promise((resolve: (user: MeProps) => void, reject) => {
    axios.get(`/me`)
      .then(({ data: { user } }) => {
        dispatch(saveMe(user));
        resolve(user);
      })
      .catch(error => reject(error));
  });
}

export const postDeviceToken = (data: any) => {
  return new Promise((resolve, reject) => {
    axios.post(`/device-token`, data)
      .then(() => resolve(true))
      .catch(error => reject(error));
  });
}

export const fetchLocation = () => {
  return new Promise((resolve, reject) => {
    axios.get(`/location`)
      .then(({ data: { location } }) => {
        dispatch(saveLocation(location));
        resolve(location);
      })
      .catch(error => reject(error));
  });
}

export const fetchPlan = () => {
  return new Promise((resolve, reject) => {
    axios.get(`/plan`)
      .then(({ data: { plan } }) => {
        dispatch(savePlan(plan));
        resolve(plan);
      })
      .catch(error => reject(error));
  });
}

export const postProfile = (data: any) => {
  return new Promise((resolve, reject) => {
    axios.post(`/profile`, data, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
      .then(({ data: { user } }) => {
        dispatch(saveMe(user));
        resolve(user);
      })
      .catch(error => reject(error));
  });
}

export const postUpdateBilling = (data: any) => {
  return new Promise((resolve: (user: MeProps) => void, reject) => {
    axios.post(`/update-billing`, data)
      .then(({ data: { user } }) => {
        dispatch(saveMe(user));
        resolve(user);
      })
      .catch(error => reject(error));
  });
}

export const postFirstPayment = () => {
  return new Promise((resolve, reject) => {
    axios.post('/first-payment')
      .then(({ data: { user } }) => {
        dispatch(saveMe(user));
        resolve(user);
      })
      .catch(error => reject(error));
  });
}

export const postUpdatePassword = (data: any) => {
  return new Promise((resolve, reject) => {
    axios.post(`/update-password`, data)
      .then(() => resolve(true))
      .catch(error => reject(error));
  });
}

export const postPlanChangeRequest = (data: any) => {
  return new Promise((resolve, reject) => {
    axios.post(`/plan-change-request`, data)
      .then(() => resolve(true))
      .catch(error => reject(error));
  });
}

export const fetchFamilies = () => {
  return new Promise((resolve: (data: {families: MemberProp[], limit: number}) => void, reject) => {
    axios.get(`/families`)
      .then(({ data }) => resolve(data))
      .catch(error => reject(error));
  });
}

export const postInviteMember = (data: any) => {
  return new Promise((resolve, reject) => {
    axios.post(`/invite-member`, data)
      .then(() => resolve(true))
      .catch(error => reject(error));
  });
}

export const postAddChildMember = (data: any) => {
  return new Promise((resolve, reject) => {
    axios.post(`/add-child`, data)
      .then(() => resolve(true))
      .catch(error => reject(error));
  });
}

export const fetchFamilyMember = (memberID: string) => {
  return new Promise((resolve: (member: MeProps) => void, reject) => {
    axios.get(`/family-member/${memberID}`)
      .then(({ data: { member } }) => resolve(member))
      .catch(error => reject(error));
  });
}

export const postFamilyMember = (memberID: string, data: any) => {
  return new Promise((resolve, reject) => {
    axios.get(`/family-member/${memberID}`, data)
      .then(({ data: { member } }) => resolve(member))
      .catch(error => reject(error));
  })
}

export const deleteFamilyMember = (memberID: string) => {
  return new Promise((resolve, reject) => {
    axios.delete(`/family-member/${memberID}`)
      .then(() => resolve(true))
      .catch(error => reject(error));
  })
}

export interface InvoiceProp {
  invoiceID: string,
  period: string,
  amount: number,
  period_timestamp: number
}
export const fetchInvoices = () => {
  return new Promise((resolve: (invoices: InvoiceProp[]) => void, reject) => {
    axios.get(`/invoices`)
      .then(({ data }) => resolve(data.invoices))
      .catch(error => reject(error));
  });
}

export const fetchInvoiceDetail = (invoiceID: string) => {
  return new Promise((resolve, reject) => {
    axios.get(`/invoices/${invoiceID}`)
      .then(({ data }) => resolve(data.invoice))
      .catch(error => reject(error));
  });
}

export interface ActivityProp {
  category: string,
  detail: string,
  price: number,
  date: string,
  timestamp: number,
  member: {
    name: string,
    avatar: string,
  },
  items: {
    name: string,
    price: number,
  }[]
}
export const fetchActivities = () => {
  return new Promise((resolve: (activities: ActivityProp[]) => void, reject) => {
    axios.get(`/activities`)
      .then(({ data }) => resolve(data.activities))
      .catch(error => reject(error));
  });
}

export interface MemberProp {
  memberID: string,
  name: string,
  email: string,
  phone: string,
  avatar: string,
  profile: {
    share_age_gender: boolean,
    age: number,
    gender: string,
    rating: number,
    matches: number,
    wins: number,
    losses: number,
  },

  is_child: boolean,

  email_share: boolean,
  phone_share: boolean,
  my_email_share: boolean,
  my_phone_share: boolean,
  friend_status: '' | 'pending' | 'waiting' | 'accepted',
}
export const fetchMembers = (route: string) => {
  return new Promise((resolve: (data: {members: MemberProp[], pending_requests: number}) => void, reject) => {
    axios.get(route)
      .then(({ data }) => resolve(data))
      .catch(error => reject(error));
  });
}

export const fetchMemberDetail = (memberID: string) => {
  return new Promise((resolve: (member: MemberProp) => void, reject) => {
    axios.get(`/members/${memberID}`)
      .then(({ data }) => resolve(data.member))
      .catch(error => reject(error));
  });
}

export const postMemberInvite = (memberID: string, data: any) => {
  return new Promise((resolve, reject) => {
    axios.post(`/members/${memberID}/invite`, data)
      .then(() => resolve(true))
      .catch(error => reject(error));
  });
}

export const postMemberAccept = (memberID: string, data: any) => {
  return new Promise((resolve, reject) => {
    axios.post(`/members/${memberID}/accept`, data)
      .then(() => resolve(true))
      .catch(error => reject(error));
  });
}

export const postMemberDecline = (memberID: string) => {
  return new Promise((resolve, reject) => {
    axios.post(`/members/${memberID}/decline`)
      .then(() => resolve(true))
      .catch(error => reject(error));
  });
}

export const postMemberShareSetting = (memberID: string, data: any) => {
  return new Promise((resolve, reject) => {
    axios.post(`/members/${memberID}/share-setting`, data)
      .then(() => resolve(true))
      .catch(error => reject(error));
  });
}

export const postMemberRemove = (memberID: string) => {
  return new Promise((resolve, reject) => {
    axios.post(`/members/${memberID}/remove`)
      .then(() => resolve(true))
      .catch(error => reject(error));
  });
}

export const fetchSocial = () => {
  return new Promise((resolve, reject) => {
    axios.get(`/settings/social`)
      .then(({ data: { social } }) => {
        dispatch(saveSocial(social));
        resolve(social);
      })
      .catch(error => reject(error));
  });
}

export const fetchDashboard = () => {
  return new Promise((resolve, reject) => {
    axios.get(`/settings/dashboard`)
      .then(({ data: { dashboard } }) => {
        dispatch(saveDashboard(dashboard));
        resolve(dashboard);
      })
      .catch(error => reject(error));
  });
}

export interface PlanProp {
  id: string,
  name: string,
  price: number,
}
export const fetchPlans = () => {
  return new Promise((resolve: (plans: PlanProp[]) => void, reject) => {
    axios.get(`/settings/plans`)
      .then(({ data }) => resolve(data.plans))
      .catch(error => reject(error));
  });
}

export interface KitchenBarData {
  itemID: string,
  category: string,
  item: string,
  price: number,
}
export interface KitchenBarProp {
  category: string,
  data: KitchenBarData[]
}
export const fetchKitchenBars = () => {
  return new Promise((resolve: (items: KitchenBarProp[]) => void, reject) => {
    axios.get(`/settings/kitchen-bars`)
      .then(({ data }) => resolve(data.items))
      .catch(error => reject(error));
  });
}

export const logout = () => {
  return new Promise((resolve, reject) => {
    axios.get(`/logout`)
      .then(() => resolve(true))
      .catch(error => reject(error))
      .finally(() => dispatch(saveAccessToken(null)));
  });
}
