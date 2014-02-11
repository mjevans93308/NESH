//
//  IosSnippets.m
//  IosSnippets
//
//  Created by Aaraadhya Narra on 2/4/14.
//  Copyright (c) 2014 nesh.co. All rights reserved.
//

#import "IosSnippets.h"

@interface IosSnippets() <NSURLConnectionDelegate>
{
    NSMutableData* _response;
}
@end

@implementation IosSnippets
-(BOOL) track:(NSString *)properties{
    
    //CREATE THE REQUEST
    NSMutableURLRequest *request = [NSMutableURLRequest requestWithURL:[NSURL URLWithString:@"https://www.NESH.co/getData.php"]];
    [request setValue:@"application/x-www-form-urlencoded" forHTTPHeaderField:@"Content-Type"];
    [request setHTTPMethod:@"POST"];
    [request setHTTPBody:[NSData dataWithBytes:[properties UTF8String] length:strlen([properties UTF8String])]];
    
    //CREATE THE CONNECTION AND FIRE IT
    NSURLConnection *conn = [[NSURLConnection alloc] initWithRequest:request delegate:self];
    return true;
}



- (void)connection:(NSURLConnection *)connection didReceiveResponse:(NSURLResponse *)response {
    // A response has been received, this is where we initialize the instance var you created
    // so that we can append data to it in the didReceiveData method
    // Furthermore, this method is called each time there is a redirect so reinitializing it
    // also serves to clear it
    _response = [[NSMutableData alloc] init];
}

- (void)connection:(NSURLConnection *)connection didReceiveData:(NSData *)data {
    // Append the new data to the instance variable you declared
    [_response appendData:data];
}

- (NSCachedURLResponse *)connection:(NSURLConnection *)connection
                  willCacheResponse:(NSCachedURLResponse*)cachedResponse {
    // Return nil to indicate not necessary to store a cached response for this connection
    return nil;
}

- (void)connectionDidFinishLoading:(NSURLConnection *)connection {
    // The request is complete and data has been received
    // You can parse the stuff in your instance variable now
    
}

- (void)connection:(NSURLConnection *)connection didFailWithError:(NSError *)error {
    // The request has failed for some reason!
    // Check the error var
}
@end
