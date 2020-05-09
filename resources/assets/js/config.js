const devDomainURL = 'http://e-diary.local';
const prodDomainURL = 'http://e-diary.bspu.by';
export const domainURL = process.env.NODE_ENV === 'development' ? devDomainURL : prodDomainURL;
