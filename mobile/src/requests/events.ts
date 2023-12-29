import axios from 'axios';
import { parse as HtmlParse} from 'fast-html-parser';
import rssParser from 'react-native-rss-parser';
import _ from 'lodash';

export interface EventProp {
  id: string
  image: string | null
  date: string
  title: string
  link: string
}
export const fetchEvents = () => {
  return new Promise((resolve: (value: EventProp[]) => void) => {
    axios.get(`https://ppbrva.com/feed/`)
    .then(({ data }) => {
      rssParser.parse(data)
      .then(rss => {
        resolve(rss.items.map(item => {
          const img = HtmlParse(item.content).querySelector('#rss-image img');
          return {
            id: item.id,
            image: img ? (_.trim(img.rawAttributes.src, '"<')) : null,
            date: item.published,
            title: item.title,
            link: item.links[0].url
          }
        }));
      }).finally(() => resolve([]));
    }).finally(() => resolve([]));
  });
}
